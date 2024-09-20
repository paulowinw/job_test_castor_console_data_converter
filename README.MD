# Data Writers and Structured Data Processing

This repository outlines a well-structured approach for data processing, focusing on data writers and related classes with specific functionalities. The design leverages multiple design patterns to achieve flexibility and maintainability.

## Folder Structure

The following folder structure promotes organization and clarity:

* **DataWriters**: This directory houses classes responsible for writing data in various formats, such as CSV.
* **ConversionValueObjects**: Here, you'll find classes dedicated to representing data fields conversions and transformation logic.
* **InputDateSources**: This folder contains classes tasked with reading data from diverse sources like JSON, CSV, and RSS.
* **Commands**: This folder contains classes the commands that can be used on the console, it uses symfony.

## Design Patterns

The project employs a combination of design patterns for robust data handling:

**Factory Pattern (DataWriters)**

* Data writers are designed using the factory pattern. This allows for creation of specific writer instances based on the type of data (e.g., `DoctorWriter`, `PatientWriter`). This promotes flexibility and reusability, enabling you to create new writers for different data formats with minimal code changes.

**Strategy Pattern (FieldValueObjects and InputDataSources)**

* **FieldValueObjects:** These classes follow the strategy pattern with a `transform` method. This method facilitates data transformation to the desired format, ensuring consistency and allowing for customization based on specific data field requirements. The strategy pattern enhances flexibility and separation of concerns.
* **InputDataSources:** These classes also leverage the strategy pattern through a `readData` method. This method varies depending on the data source format (JSON, CSV, RSS). This pattern offers modularity and makes it easy to add support for new data sources by implementing the `readData` method for each new format.

**Value Objects (FieldValueObjects)**

* FieldValueObjects embody value objects, a well-known concept in object-oriented programming. These classes encapsulate data fields and their associated behavior, such as validation and formatting. This ensures data integrity and reduces the risk of errors.

**Commands (Commands)**

* Commands in Symfony are a powerful tool for automating tasks and performing maintenance operations on your application. They are essentially executable scripts that can be run from the command line using the bin/console command.

## Getting Started

1. **Prerequisites:** Ensure you have PHP installed on your system and composer.

2. **Clone the Repository:**
   ```bash
   git clone https://github.com/paulowinw/job_test_castor_console_data_converter

3. **Run composer install:**
   ```bash
   composer install

4. **Navigate to the Project Directory:**
   ```bash
   cd <your-repository-name>

5. **Run the project with the main command:**
   ```bash
   php index.php prepare:data