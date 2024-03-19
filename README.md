# Marvel Web

## Descrição
O Marvel Web é uma plataforma de gerenciamento de personagens e quadrinhos do universo Marvel, projetada para proporcionar uma experiência interativa e dinâmica aos fãs da franquia. A aplicação oferece uma variedade de recursos, desde o cadastro de novos usuários até a gestão de favoritos.

Após se cadastrar na plataforma, os usuários têm acesso à página inicial, onde podem explorar uma ampla gama de personagens e quadrinhos. Eles têm a capacidade de cadastrar novos personagens e quadrinhos, editar informações existentes e excluir itens conforme necessário. Além disso, os usuários podem marcar seus personagens favoritos, que serão exibidos em uma lista separada na aba de favoritos.

Com uma interface intuitiva e funcionalidades poderosas, o Marvel Web oferece uma experiência completa para os fãs da Marvel, permitindo-lhes mergulhar ainda mais no fascinante universo dos super-heróis e vilões.

## Requisitos
- PHP 8.1
- Composer
- Node.js 21.7.1
- MySQL

## Instalação
1. Clone o repositório do projeto do GitHub:
 git clone https://github.com/Lvinicius/marvel_web.git

2. Navegue até a pasta do projeto:
cd marvel_web/project

3. Instale as dependências do PHP usando o Composer:
composer install

4. Instale as dependências do Node.js:
npm install

5. Prepare o Artisan: 
php artisan migrate
php artisan 
php artisan storage:link

## Uso
1. Inicie o servidor PHP:
php artisan serve

2. Abra um navegador da web e vá para http://localhost:8000/login
