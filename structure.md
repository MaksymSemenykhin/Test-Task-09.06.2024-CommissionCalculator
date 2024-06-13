# Project Structure

- src/: Main classes used for commission calculations.

- Adapters/: Adapters for various data sources.
- Abstracts/: Abstract classes providing base functionality.
- Contracts/: Interfaces defining contracts for classes.
- Enums/: Enumerations used for strict typing.
- Factories/: Factories for creating instances of various classes.
- Models/: Models representing data.
- Outputs/: Classes for outputting results in different formats.
- Repositories/: Repositories for managing transaction and withdrawal data.
- Services/: Services for working with exchange rates and commission calculations.
- Strategies/: Strategies for calculating commissions for different operation types.
- Traits/: Traits providing common methods.
- tests/: Tests for verifying the functionality of the system.

- input.csv: Example input data for tests.
- input_private_with_limit.csv: Example data for testing private client withdrawals with limits.
- input_business.csv: Example data for testing business client withdrawals.
- index.php: Main script for running the system. Used for reading data from a CSV file and calculating commissions.