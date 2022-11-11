<?php

namespace App\Service;

use App\Entity\TemperatureQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class TemperatureQueryManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $data
     *
     * @return float[]
     */
    public function calculateMkt(array $data): array
    {
        try {
            $array = '{"temp1":"25.0","temp2":"24.0","temp3":"32.0","temp4":"26.0","temp5":"23.0","temp6":"21.0","temp7":"19.0","temp8":"20.0","temp9":"20.0","temp10":"25.0","temp11":"26.0","temp12":"27.0","temp13":"25.0","temp14":"24.0","temp15":"26.0"}';

            $tempArray = json_decode($array, true);

            $numerator = $this->numerator();
            $expoNantialValue = 0;
            $numberOfTemperatureRecords = 0;

            foreach ($tempArray as $key => $temperatureValue) {
                $numberOfTemperatureRecords++;
                $temperatureValue = $this->temperatureInKelvin((float)$temperatureValue);

                $rt = TemperatureQuery::GAS_CONSTANT_VALUE_R * $temperatureValue;
                $negativeExponantialValue = TemperatureQuery::GAS_CONSTANT_VALUE_H / $rt;

                $expoNantialValue += exp(1 / $negativeExponantialValue);
            }

            $expoNantialValue = $expoNantialValue / $numberOfTemperatureRecords;

            $logarithamValue = (1 / log($expoNantialValue));

            $mkt = $numerator / $logarithamValue;

            //echo "MKT in kelvin is: " . $mkt;

            // echo "MKT in celsius is: " . $this->temperatureInCelsius($mkt);

            return ["mkt" => $this->temperatureInCelsius($mkt)];
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
}