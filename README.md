# uplexis-teste
Teste aplicado pela empresa Uplexis, onde o objetivo é carregar informações de uma página de terceiros, gravar em banco e dados, listá-las e excluí-las.

## Instalação
- Faça o clone do projeto em um diretório local com o comando abaixo:
<pre>git clone https://github.com/juniormorete/uplexis</pre>
- Abra o CMD, navegue até o diretório ".docker" na raiz do projeto e execute o comando abaixo:
<pre>docker-compose up -d --build</pre>
- Acesse o container "ul_mysql8", conecte ao banco de dados e, na sequência, digite a senha "analista123". Daremos permissão total ao usuário "analista" e criaremos o schema "uplexis" para a aplicação. Os comandos para esta operação são (usuário, senha e schema podem ser diferentes dos citados, porém caso seja, configure a conexão do banco de dados no arquivo ".env"):
<pre>
mysql -u root -p
analista123
GRANT ALL PRIVILEGES ON *.*  TO 'analista'@'%';
FLUSH PRIVILEGES;
CREATE SCHEMA \`uplexis\`;
EXIT;
</pre>
- Acesse o container "ul_php8" e execute os comandos:
<pre>
cd /var/www/html
composer install
php artisan migrate
php artisan db:seed
</pre>
- Acesse o endereço do projeto em "http://localhost:8010/" e faça login com usuário "admin@admin.com" e senha "admin";