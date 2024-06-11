[![CI/CD Pipeline](https://github.com/MaksymSemenykhin/Test-Task-09.06.2024-CommissionCalculator/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/MaksymSemenykhin/Test-Task-09.06.2024-CommissionCalculator/actions/workflows/ci.yml)

## Описание

Эта программа рассчитывает комиссию для операций депозитов и снятия средств на основе правил, описанных в задании. Комиссия рассчитывается для частных и бизнес клиентов с учетом валют и недельных лимитов.
# Commission Calculator

## Запуск системы

Для расчета комиссии:
php index.php input.csv

## Запуск тестов

Для запуска всех тестов:
vendor/bin/phpunit tests

## Описание

Программа рассчитывает комиссии для депозитов и снятий, основываясь на правилах для частных и бизнес клиентов, с учетом валют и недельных лимитов.

### Структура проекта
- `src/`: Основные классы.
- `tests/`: Тесты.
- `index.php`: Основной скрипт запуска.

### Конфигурация валют
Курсы валют фиксированы и определены в `ExchangeRateService.php`.
