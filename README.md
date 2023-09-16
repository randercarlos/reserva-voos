# Sistema de Reservas de Passagens Aéreas

O objetivo do sistema é possibilitar o controle de total das reservas de passagens aéreas pelos administradores de
uma empresa de companhia aérea.

O sistema possibilita fazer a gestão(inclusão, alteração, listagem e exclusão) de aviões, marcas/empresas de aviões,
voos, aeroportos, cidades/estados, reservas e usuários.


![](https://ibb.co/iM5ZEd)
![](https://ibb.co/juqvLJ)
![](https://ibb.co/cZNNZd)


O sistema pode ser acessado em: https://reserva-voos-8f0bbf625646.herokuapp.com/

Área administrativa. Dados de acesso:

Email: admin@admin.com
Senha: admin

## Iniciando

Para acessar o sistema, informe o host ou domínio onde o sistema foi instalado. Ex: https://reserva-voos-8f0bbf625646.herokuapp.com/

Para acessar a área administrativa do sistema. clique no link 'Área Administrativa' na tela principal.

O sistema mostrará a tela de login. Informe as seguintes credenciais:

Email: admin@admin.com
senha: admin

Clique em entrar e, se as credenciais foram corretamente digitadas, será mostrada a área administrativa do sistema

### Pré-requisitos

Esse projeto foi desenvolvido com o framework Laravel v5.6. Portanto, ele possui os mesmos pré-requisitos do framework.

Esse requisitos são:
- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension

Além do banco de dados MySQL v5.6 e servidor Web PHP que pode ser o Apache HTTP Server ou Nginx.


### Instalando

-  Instale todos os pré-requisitos da aplicação mostrados no passo anterior.

- Copie o código-fonte do projeto para uma pasta do seu computador

- Configure as variáveis de ambiente do projeto para que possa acessar o banco de dados. As variáveis a serem
  configuradas são:

DB_CONNECTION=mysql
DB_HOST=seu-host
DB_PORT=3306
DB_DATABASE=reserva-voos
DB_USERNAME=seu-usuario
DB_PASSWORD=sua-senha

- Acesse o banco de dados MySQL e crie o banco baseado no valor da variável de ambiente 'DB_DATABASE'. O Laravel usará
  esse banco para a aplicação

- Abra o terminal e navegue até a pasta raiz da aplicação. Ao estar na raiz da aplicação, crie as tabelas do sistema
  através do comando:

php artisan migrate

- Pronto. Agora o sistema está instalado!

OBS: É necessário entrar no banco de dados da aplicação, na tabela users e cadastrar manualmente um usuário para que
possa logar na aplicação.

## Desenvolvido com

* [Laravel](https://laravel.com/) - Framework Web usado
* [MySQL](https://www.mysql.com/) - Banco de dados usado
* [Nginx](https://www.nginx.com/) - Servidor Web usado

## Versionamento

Nós usamos [SemVer](http://semver.org/) para versionamento.

## Autor

* **Rander Carlos** - *Desenvolvedor do Projeto* - [Github](https://github.com/randercarlos)

## Licença

Esse projeto possui o seu código-fonte privado.
