## Project Description

This project is a web application built using the Laravel framework and MySQL database to provide customers with seamless access to their purchased courses. In addition to course access, the portal includes an Achievement System to enhance the user experience, encouraging engagement and progression.

## Installation

To install this project, follow these steps:

1. Clone the repository: `https://github.com/hasithadaffy/backend-developer-test-l10.git`
2. Install dependencies: `composer install`
3. Create the application key: `php artisan key:generate`
4. Run the application: `php artisan serve`
5. Run migrations: `php artisan migrate`
6. Run seeders: `php artisan db:seed, php artisan db:seed UserSeeder, php artisan db:seed CommentSeeder`

## Test Cases

Our test cases are written using PHPUnit. They cover various aspects of the application to ensure its correct functionality. Here's a brief overview:

-   **Unit Tests:** These tests cover the individual units of the application, such as the `AchievementService` and `BadgeService`. They ensure that these services work as expected in isolation.

-   **Integration Tests:** These tests cover the interaction between different parts of the application. They ensure that the services work correctly when used together.

-   **Functional Tests:** These tests cover the functionality of the application from the user's perspective. They ensure that the application works correctly when used as intended.

To run the tests, use the following command:

`php artisan test`

## Service Classes

The project includes the following service classes:

## AchievementService

`AchievementService` is a core component of our application. It is responsible for managing user achievements. This includes tracking user progress, unlocking achievements when certain conditions are met, and providing a list of all achievements a user has earned.

## BadgeService

`BadgeService` is another crucial component of our application. It works in tandem with the `AchievementService`. While `AchievementService` tracks user progress, `BadgeService` is responsible for assigning badges to users based on their achievements. It also manages the badge inventory, and provides a list of all badges a user has earned.

## Contributing

We welcome contributions from the community. Please read our [contribution guidelines](https://link-to-your-contribution-guidelines) before submitting a pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](https://link-to-your-license) file for details.

## Contact

If you have any questions or feedback, please contact us at [your-email@example.com](mailto:your-email@example.com).
