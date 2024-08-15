# Car-API: A Comprehensive Automotive Data API
<a href="https://github.com/Techni-Dan/CarAPI/blob/main/LICENSE">
<img src ="https://img.shields.io/github/license/Techni-Dan/CarAPI" />
</a>
<a href="https://github.com/Techni-Dan/CarAPI/issues">
<img src ="https://img.shields.io/github/issues/Techni-Dan/CarAPI" />
</a><br><br> 

## Abstract

This document details the functionality and usage of Car-API, a RESTful API designed to provide comprehensive access to a rich database of car brands and models (120 brands & 1891 models). This API caters to a diverse range of applications, including automotive research, market analysis, and the development of car-related web and mobile applications.

Link to the online version of the project: [Cilck here](https://apicars.technidan.com)

## 1. Introduction

Car-API offers a streamlined approach to retrieve automotive data, eliminating the need for developers to manually compile and maintain large datasets. It exposes various endpoints that enable users to query brands, models, and their relationships. The API is built on the Symfony framework, ensuring robust performance and scalability.

## Setting up the working environment

- my device: [Apple Mac Mini - Apple M2 Pro](https://www.apple.com/newsroom/2023/01/apple-introduces-new-mac-mini-with-m2-and-m2-pro-more-powerful-capable-and-versatile-than-ever/)

- operating system: [macOS Sonoma 14.6.1](https://developer.apple.com/documentation/macos-release-notes/macos-14_3-release-notes)

- IDE: [Visual Studio Code 1.92.1](https://code.visualstudio.com/)

- version control system: [Git version 2.46.0](https://git-scm.com/)

- local webserver: [XAMPP 8.2.4-0](https://www.apachefriends.org/download.html)

- general purpose scripting language: [PHP 8.3.10](https://formulae.brew.sh/formula/php)

- dependency management in PHP: [Composer version 2.7.7](https://getcomposer.org/download/)

- developer tool to build, run, and manage your Symfony applications: [Symfony CLI version 5.10.2](https://symfony.com/download)

- JavaScript runtime: [Node.js 20.16.0](https://nodejs.org/en/download)

- npm Node.js Package Manager: [npm 10.8.1](https://docs.npmjs.com/try-the-latest-stable-version-of-npm)

- npx package runner: [npx 10.8.1](https://www.npmjs.com/package/npx)

- package manager: [yarn 1.22.22](https://classic.yarnpkg.com/lang/en/docs/install/)

- web browser: [Google Chrome 127.0.6533.120](https://www.google.com/intl/en/chrome/)

## Installation

You can clone this repository to create a local copy on your computer:

```bash
git clone git@github.com:Techni-Dan/CarAPI.git
```

After configuring the work environment you can proceed to installing the necessary components. You need to open the cloned project in your IDE. In the terminal of your IDE you must go to the folder of the newly created project after the cloning if it is not already the case:

```bash
cd apicar
```

With this command, in the terminal you install the dependencies of the project present in [composer.json](composer.json):

```bash
composer install
```

If composer is not installed on your work environment, you will find at this address information allowing you to install it:

- [https://getcomposer.org/download/](https://getcomposer.org/download/)


## 2. Data Generation and Integration

### 2.1 Integrating Data into Symfony

You can integrate the generated data into your Symfony Car-API application using the following methods:

### 2.1.1 Creating the Database with Symfony

You can create the database using Symfony commands and the database credentials specified in your [`.env`](.env) file:

#### Create the Database:

Run the following command in your terminal:

```bash
symfony console doctrine:database:create
```

#### And apply the migration present in [migrations](/migrations/Version20240815123001.php) by runing the following command in your terminal:

```bash
symfony console doctrine:migration:migrate
```

#### Insert JSON Data into the database:

[ImportCarDataCommand.php](/resources/Command/ImportCarDataCommand.php) creates a custom Symfony command that parses [Brands_&_Models.json](/resources/Command/Brands_&_Models.json).

Run the following command in your terminal:

```bash
php bin/console app:import-car-data  
```

#### Start Symfony server

Run the following command in your terminal:

```bash
symfony serve
```

#### Click to open [https://127.0.0.1:8000/api/brandsmodels](https://127.0.0.1:8000/api/brandsmodels)
or 
#### Cmd+Click in the terminal on [https://127.0.0.1:8000](https://127.0.0.1:8000) then in the search bar add the rest of the route, for example: /api/cars

## Alternatives

Before using the Car-API, you need to populate your database with car brand and model information. This project provides two scripts located in the [`src/resources/Command/`](/resources/Command/) directory to facilitate this process:

- **`generatejson.php`:** Generates a JSON file [`Brands & Models.json`](/resources/Command/Brands_&_Models.json) containing a structured representation of car brands and models. 
- **`generatesql.php`:** Generates an SQL file [`Brands & Models.sql`](/resources/Command/Brands_&_Models.sql) with `INSERT` statements for populating a MySQL database.

Both scripts leverage a common data source, the `$modelsByMarque` array, defined within each script. This array contains a hierarchical structure of brands and their associated models.

### **2.2 `generatejson.php`**

This script iterates through the `$modelsByMarque` array, assigns unique IDs to each brand and model, and constructs a JSON array. Each element in the array represents a car with the following structure:

```json
[
    {
        "brand": "Abarth",
        "models": [
            {
                "id": 1,
                "name": "124"
            },
            {
                "id": 2,
                "name": "124 Spider"
            },
            {
              
            }
        ]
    }
]
```

The generated JSON data is saved to Brands_&_Models.json using the saveJsonToFile() function.

### 2.3 generatesql.php

This script generates two SQL INSERT statements:

INSERT INTO brand (id, nom): Populates the brand table with unique brand names extracted from $modelsByMarque.

INSERT INTO model (id, brand_id, nom): Populates the model table, associating models with their corresponding brands using the generated brand IDs.

The SQL statements are saved to Brands_&_Models.sql using the saveSqlToFile() function.


### 2.3.1 SQL Statements:

Execute the SQL statements from [Brands_&_Models.sql](/resources/Command/Brands_&_Models.sql) against your application's database using a MySQL client or tool.

### **2.3.2 Create and populating the Database**

The [`ApiCars.sql`](/resources/Command/ApiCars.sql) file contains a SQL dump of the `ApiCars` database. To import the database:

1. Import the `ApiCars.sql` file into phpMyAdmin [http://127.0.0.1/phpmyadmin/index.php](http://127.0.0.1/phpmyadmin/index.php?route=/server/import) to do this.


### 3. API Endpoints

The following table summarizes the available API endpoints:

| Endpoint           | Method | Description                                                                 | Example Response                                                         |
|--------------------|--------|-----------------------------------------------------------------------------|--------------------------------------------------------------------------|
| [/api/brandsmodels](https://apicars.technidan.com/api/brandsmodels)          | GET    | Retrieves a complete list of all cars, including their brands and models.   | `[{"brand": "Abarth", "models": [{"id": 1,"name": "124"}, ...]`                   |
| [/api/brands](https://apicars.technidan.com/api/brands)   | GET    | Returns a distinct list of all car brands, each with a unique ID.            | `[{"id": 1,"name": "Abarth"},{"id": 2,"name": "Acura"}, ...]`     |
| [/api/models](https://apicars.technidan.com/api/models)  | GET    | Provides a distinct list of all car models, each with a unique ID.           | `[{"id": 1,"name": "124"},{"id": 2,"name": "124 Spider"}, ...]` |
| [/api/models/{brand}](https://apicars.technidan.com/api/models/Bugatti) | GET    | Retrieves all models associated with a specific car brand.                 | `[{"id": 193,"name": "Centodieci"},{"id": 194,"name": "Chiron"},{"id": 195,"name": "Divo"}, ...]` |
| [/api/brand/{model}](https://apicars.technidan.com/api/brand/Tourbillon) | GET    | Returns the brand(s) associated with a specific car model.                 | `{"id": 12,"name": "Bugatti"}`                                 |

### 4. Implementation Details

Car-API is built using:

Symfony Framework: Provides a robust and scalable foundation for the API.

Doctrine ORM: Enables efficient database management and interaction with the Car entity.

JMS Serializer: Serializes data into JSON format for efficient data transfer.


### 4.1 Data Structure

The Car entity represents a car in the database and has the following attributes:

id: Unique identifier.

brand: The brand of the car.

model: The specific model of the car.


### 4.2 Serialization Groups

JMS Serializer uses serialization groups to control which attributes are included in the JSON responses. The Car entity has these defined:

getCars: Includes brand and model attributes.

getBrands: Includes only the brand attribute.

getModels: Includes only the model attribute.

### 5. Usage Examples

You can interact with the Car-API using cURL:

### 5.1 Retrieve All Brands:

```bash
curl https://apicars.technidan.com/api/brands
```

### 5.2 Get Models for a Specific Brand:

```bash
curl https://aapicars.technidan.com/api/models/Bugatti
```
### 5.3 Find the Brand of a Model:

```bash
curl https://apicars.technidan.com/api/brand/Turbillon
```

### 6. Conclusion

Car-API offers a powerful and user-friendly solution for accessing automotive data. Its clear structure and well-defined endpoints make it an invaluable resource for developers and researchers.

### 7. Future Work

Future development will focus on:

Dataset Expansion: Adding more brands, models, and attributes like technical specifications, dimensions, safety features, and pricing information.

Enhanced Features: Implementing search and filtering capabilities and incorporating more advanced data analysis functionalities.

### 8. Acknowledgements

The development of Car-API was driven by the need for easily accessible automotive data in the research and development communities.