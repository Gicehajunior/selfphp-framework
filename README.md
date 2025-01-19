## SelfPHP Framework 
<p align="center">
    <img style="display: block; margin: 0 auto" src="public/storage/logo/sp-logo.png" height="250" width="250">
</p>


A framework to give you a headstart to your project. To understand more on the framework, A full documentation is on the way coming. Visit this repository regularly for more on the detailed documentation and community setup updates.


# Get Started
This guide will help you set up the SelfPhp Framework on your local machine and get it running.

## Steps to Set Up

### 1. Clone the Repository
Clone the SelfPhp Framework repository from GitHub to your local machine.

```bash
git clone https://github.com/Gicehajunior/selfphp-framework.git
```

### 2. Navigate to the Cloned Repository
After cloning the repository, navigate to the project folder.

```bash
cd selfphp-framework
```

### 3. Set Up Configuration File
You need to set up the configuration for your project. The framework uses a `.env` file for environmental configurations. You can create the `.env` file by copying the example template.

```bash
cp .env.example .env
```

Edit the `.env` file to set up your database connection, app URL, and other necessary configurations.

```bash
nano .env
```

### 4. Install Composer Dependencies
SelfPhp Framework relies on Composer for managing PHP dependencies. Install the required dependencies using the following command:

```bash
composer install
```

### 5. Install Assets (JavaScript, CSS, etc.)
To set up the frontend assets (JavaScript, CSS, JQuery etc.), you will need to run the `npm` build process.

First, install the required Node.js dependencies:

```bash
npm install
```

Then, build the assets:

```bash
npm run build
```

### 6. Run the Framework
Once everything is set up, you can run the SelfPhp framework with the following command:

```bash
selfphp sp-cmd run -o 8200
```

- The `-o` flag **overrides** the default port (8000) and sets the server to run on port 8200.
- If you do not specify the `-o` flag, the server will run on the default port, which is **8000**.

This will start the framework and make it accessible at [http://localhost:8200](http://localhost:8200) (or [http://localhost:8000](http://localhost:8000) if you skip the `-o` flag).

## Collaborations
We welcome contributions! If you want to contribute to the SelfPhp Framework, please fork the repository and submit a pull request. 

When submitting a pull request:
- Ensure that your code is properly tested.
- Follow the coding conventions used in the project.
- Provide a clear description of what your changes do.

## Reporting Issues
If you encounter any bugs or issues, please report them by opening an issue on the GitHub repository.

To report an issue:
1. Check the existing issues to see if the problem has already been reported.
2. If not, create a new issue with a detailed description of the problem.
3. Include any relevant error messages, logs, and steps to reproduce the issue


## Buy me a coffee
If you like my work, you can buy me a coffee. I will appreciate that a lot 🙏🏼


[![Giceha Junior](https://img.shields.io/badge/Buy%20Me%20a%20Coffee-Donate-orange?style=for-the-badge&logo=ko-fi)](https://www.buymeacoffee.com/gicehajunior)

## License
This project is licensed under the MIT License - see the [LICENSE](https://github.com/Gicehajunior/selfphp-framework/blob/main/LICENSE) file for details.

