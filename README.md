# symfony-mkt
Symfony framework RestAPI- calculating mkt

Created two REST API which are as below:

1. POST `/temperature`   It accepts the file as myFile with the provided sample JSON file and shows the mkt in celsius and kelvin both.

2. GET `/temperature`  - It returns all the results of a user checking from a particular IP address.

I included a unit test case also and generated migration as well.
Sample json data for the file is as below:

`{"temp1":"25.0","temp2":"24.0","temp3":"32.0","temp4":"26.0","temp5":"23.0","temp6":"21.0","temp7":"19.0","temp8":"20.0","temp9":"20.0","temp10":"25.0","temp11":"26.0","temp12":"27.0","temp13":"25.0","temp14":"24.0","temp15":"26.0"}`

