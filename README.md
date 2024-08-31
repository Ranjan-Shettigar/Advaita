# College Fest Management System

This project is a PHP-based system for managing a college fest, including database connectivity and payment integration.

## Configuration

The system uses the following configuration:

### Database Configuration

- Server: localhost
- Username: root
- Password: (empty)
- Database Name: college_fest

### UPI Payment Configuration

- UPI ID: yourupiid123@okhdfcbank
- Payee Name: Receivername
- Currency: INR
- AID: uGICAgMDM4aL2Ng

### Gmail Configuration

The system uses Gmail for sending emails. The following credentials are used:

- Username: yur@gmail.com
- Password: [Redacted for security]
- Sender Email: yur@gmail.com

## Setup

1. Ensure you have PHP and MySQL installed on your system.
2. Create a database named `college_fest` in your MySQL server.
3. Update the database configuration in the PHP file if your setup differs from the default.
4. Update the UPI payment configuration with your actual UPI details.
5. Update the Gmail configuration with your actual Gmail credentials.

## Modifying config.php

To set up the system for your specific needs, you need to modify the `config.php` file. Follow these steps:

1. Locate the `config.php` file in the root directory of the project.
2. Open the file in a text editor.
3. Update the following sections according to your requirements:

   a. Database Configuration:
   ```php
   $servername = "your_server_name";
   $username = "your_database_username";
   $password = "your_database_password";
   $dbname = "your_database_name";
   ```

   b. UPI Payment Configuration:
   ```php
   $upi_id = "your_upi_id@provider";
   $payee_name = "Your Name";
   $currency = "INR";
   $aid = "your_aid";
   ```

   c. Gmail Configuration:
   ```php
   define('GMAIL_USERNAME', 'your_gmail@gmail.com');
   define('GMAIL_PASSWORD', 'your_app_password');
   define('GMAIL_SENDER_EMAIL', 'your_gmail@gmail.com');
   ```

4. Save the changes to the `config.php` file.

Remember to replace the placeholder values with your actual configuration details. Ensure that you keep this information secure and do not share it publicly.

## Accessing Admin Dashboard

You can access the admin dashboard by navigating to:

```
yourdomain/admin.php
```

Use the following credentials to log in:

- Username: admin
- Password: qwe123

## Obtaining Gmail Password

To obtain the Gmail password (app password) for the email functionality:

1. Ensure you have two-factor authentication activated on your Gmail account.
2. Sign in to the same Gmail account you want to use for the system.
3. Visit the following link:
   [https://myaccount.google.com/apppasswords](https://myaccount.google.com/apppasswords)
4. Follow the prompts to generate an app password.
5. Use this app password in the Gmail configuration of the system.

## Security Note

The current configuration file contains sensitive information such as database credentials and Gmail password. In a production environment, it's crucial to:

1. Use environment variables or a separate, non-tracked configuration file for sensitive data.
2. Never commit sensitive information directly to your repository.
3. Use strong, unique passwords for all services.
4. Regularly update and rotate passwords, especially for admin access.

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Acknowledgments

* This project is part of a college fest management system.
* Thanks to all contributors and participants of the college fest.
