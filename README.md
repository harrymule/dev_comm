

## About Project

This is a simple API Bild With Laravel 9 and  Sunctum for CRUD methods

## Installation Process.

Kindly Ensure that you have MYSQL, PHP and Composer installed in your Machine.

Create a database called dev_comm.

Create adatabase user called dev_comm_admin.

Create Password For the user. Default password is 'mX3XwBY56KLQmCEq'

Assign user dev_comm_admin to Dev_comm database.

git clone project or Download project

create .env file and copy contents of .env.example to .env

Run Composer Update to Install Vendor Folder

run artisan migrate to create db tables 

Run php arstisan key:generate

Run php arstisan optimize:clear

Sever Project on desired port 

run php artisan schedule:run -- this runs a scheduler that removes old records more than 30 days in the database. the scheduler runs hourly

## API Documentation

This Api constains the following APIs

1. Register -

curl --location --request POST 'dev_comm.test/api/register' \
--form 'name="harry"' \
--form 'email="harry@devcomm.com"' \
--form 'password="!Admin123"' \
--form 'confirm_password="!Admin123"'


2. Login - 
curl --location --request POST 'dev_comm.test/api/login' \
--form 'email="harry@devcomm.com"' \
--form 'password="!Admin123"'


** Register a username and a password since the Api is Auth Protected. **

3. GET Data API -

curl --location --request GET 'dev_comm.test/api/data' \
--header 'Authorization: Bearer 3|S2Ob7OwM3sOMyY9vO12CWU6mU9yQSANatCBzyblU'

** Use login Api to get a bearer token and add it to auth method when getting data. This Api gets 10 records at a time**

4. POST Data API

curl --location --request POST 'dev_comm.test/api/data' \
--header 'Authorization: Bearer 3|S2Ob7OwM3sOMyY9vO12CWU6mU9yQSANatCBzyblU' \
--form 'name="emomentum"' \
--form 'description="former company"' \
--form 'image=@"/C:/Users/harri/Downloads/emomentum.jpg"' \
--form 'type="1"'

** this api requires name, description , image (upload type is file) , and type (1 , 2 or 3) and also bearer token generated.

## Aditional API's 

5. get_records via page number

curl --location --request GET 'dev_comm.test/api/get_records/page/1' \
--header 'Authorization: Bearer 3|S2Ob7OwM3sOMyY9vO12CWU6mU9yQSANatCBzyblU'

** this api requires a bearer token generated and gets 10 records per page.

6. get one record 

curl --location --request GET 'dev_comm.test/api/get_record/2' \
--header 'Authorization: Bearer 3|S2Ob7OwM3sOMyY9vO12CWU6mU9yQSANatCBzyblU'

** this api requires a bearer token generated and gets items of a record including a temp url for an image that expires after 10 minutes.
