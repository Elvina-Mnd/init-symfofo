<h3 class="center">Welcome to this repo !</h3>

<details open="open">
  <summary>Tables of content
</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Install</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgements">Acknowledgements</a></li>
  </ol>
</details>


## About The Project

Nanga Def is an imaginary e-shop, selling clothes and accessories made Of senegalese fashion, art and crafts.

### Built With

* [Symfony](https://github.com/symfony/symfony)
* [Bootstrap](https://getbootstrap.com)
* [JQuery](https://jquery.com)
* [Sass-Lint](https://github.com/sasstools/sass-lint)
* [Twig](https://github.com/twigphp/Twig)


## Getting Started

### Prerequisites

1. Check composer is installed
2. Check yarn & node are installed

### Install

1. Clone this project
2. Run `composer install`
3. Run `yarn install`
4. Run `yarn encore dev` to build assets
5. Connect the database in the env.local
6. Run `php bin/console d:d:c`
7. Run `php bin/console make:migration`
8. Run `bin/console doctrine:migrations:migrate`
9. Sorry, no fixtures inside !


## Usage

 <ol> As a customer you can:
    <li>Register</li>
    <li>Login</li>
    <li>Buy stuff</li>
    <li>See all my commands and the details</li>
</ol>

<ol> As an admin you can (easyadmin):
    <li>See your customers</li>
    <li>Create, modify and delete products, categories, genders and sizes</li>
</ol>


## Acknowledgements

* [Font Awesome](https://fontawesome.com)


## Authors

Vina
