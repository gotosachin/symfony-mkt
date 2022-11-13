<?php

namespace App\Service;

use App\Entity\TemperatureQuery;
use AppBundle\Exception\ResourceNotFoundException;
use AppBundle\Service\InvalidInputException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Service\UploadManager\FileNotUploadedException;
use http\Exception\InvalidArgumentException;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use JMS\Serializer\SerializerInterface;

class TemperatureQueryManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string $ipAddress
     *
     * @return array
     * @throws InvalidInputException
     * @throws \Doctrine\DBAL\Exception
     */
    public function calculateMkt(UploadedFile $uploadedFile, string $ipAddress): array
    {
        try {
            $fileData = file_get_contents($uploadedFile->getRealPath(), 'r');

            // Sample json data
            // $fileData = '{"temp1":"25.0","temp2":"24.0","temp3":"32.0","temp4":"26.0","temp5":"23.0","temp6":"21.0","temp7":"19.0","temp8":"20.0","temp9":"20.0","temp10":"25.0","temp11":"26.0","temp12":"27.0","temp13":"25.0","temp14":"24.0","temp15":"26.0"}';

            $temperatureArray = json_decode($fileData, true);

            if ($temperatureArray === FALSE) {
                throw new InvalidArgumentException("Invalid json data!!");
            }

            $data = [
                'ipAddress' => $ipAddress,
                'jsonData' => $temperatureArray
            ];

            $temperatureQuery = $this->create($data);

            // Lets do calculation
            $numerator = $this->numerator();
            $exponentialValue = 0;
            $numberOfTemperatureRecords = 0;

            foreach ($temperatureArray as $key => $temperatureValue) {
                $numberOfTemperatureRecords++;
                $temperatureValue = $this->temperatureInKelvin((float)$temperatureValue);

                $rt = TemperatureQuery::GAS_CONSTANT_VALUE_R * $temperatureValue;
                $negativeExponentialValue = TemperatureQuery::GAS_CONSTANT_VALUE_H / $rt;

                $exponentialValue += exp(1 / $negativeExponentialValue);
            }

            $exponentialValue = $exponentialValue / $numberOfTemperatureRecords;

            $logarithmValue = (1 / log($exponentialValue));

            $mkt = $numerator / $logarithmValue;

            $this->update($temperatureQuery, $mkt);

            return ["mkt in celsius" => $this->temperatureInCelsius($mkt), "mkt in kelvin" => $mkt];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @return float
     */
    private function numerator(): float
    {
        return TemperatureQuery::GAS_CONSTANT_VALUE_H / TemperatureQuery::GAS_CONSTANT_VALUE_R;
    }

    /**
     * @param float $temperatureInCelsius
     *
     * @return float
     */
    private function temperatureInKelvin(float $temperatureInCelsius): float
    {
        return $temperatureInCelsius + 273.200;
    }

    /**
     * @param float $temperatureInKelvin
     *
     * @return float
     */
    private function temperatureInCelsius(float $temperatureInKelvin): float
    {
        return $temperatureInKelvin - 273.200;
    }

    /**
     * @param array $data
     *
     * @return TemperatureQuery
     * @throws InvalidInputException
     * @throws \Doctrine\DBAL\Exception
     */
    public function create(array $data): TemperatureQuery
    {
        try {
            $this->entityManager->beginTransaction();

            $temperatureQuery = new TemperatureQuery();
            $temperatureQuery->setJsonData($data['jsonData'])
                ->setIpAddress($data['ipAddress']);

            $errors = $this->validator->validate($temperatureQuery);

            if ($errors->count()) {
                throw new InvalidInputException($errors);
            }

            $this->entityManager->persist($temperatureQuery);
            $this->entityManager->flush($temperatureQuery);
            $this->entityManager->commit();
        } catch (InvalidInputException|\Exception $e) {
            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }

        return $temperatureQuery;
    }

    /**
     * @param TemperatureQuery $temperatureQuery
     * @param float $mkt
     *
     * @return TemperatureQuery
     * @throws \Doctrine\DBAL\Exception
     */
    public function update(TemperatureQuery $temperatureQuery, float $mkt): TemperatureQuery
    {
        try {
            $this->entityManager->beginTransaction();

            $temperatureQuery = $this->find($temperatureQuery->getId());

            $temperatureQuery->setMkt($mkt);

            $this->entityManager->flush($temperatureQuery);

            $this->entityManager->commit();
        } catch (ResourceNotFoundException|\Exception $e) {
            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }

        return $temperatureQuery;
    }

    /**
     * @param int $id
     *
     * @return TemperatureQuery
     */
    public function find(int $id): TemperatureQuery
    {
        /** @var TemperatureQuery $temperatureQuery */
        $temperatureQuery = $this->entityManager->getRepository(TemperatureQuery::class)->find($id);

        if (!$temperatureQuery) {
            throw new ResourceNotFoundException("No TemperatureQuery found for #{$id}");
        }

        return $temperatureQuery;
    }

    /**
     * @param string $ipAddress
     *
     * @return array
     */
    public function findTemperature(string $ipAddress): array
    {
        return $this->entityManager->getRepository(TemperatureQuery::class)->findBy(['ipAddress' => $ipAddress]);
    }
}