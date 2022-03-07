# uplexis-teste
Teste aplicado pela empresa Uplexis, onde o objetivo é carregar informações de uma página de terceiros, gravar em banco e dados, listá-las e excluí-las.

## Instalação
- Faça o pull do projeto em um diretório local;
- Via Docker:
  - Acesse o diretório ".docker" e execute o comando "docker-compose up -d --build";
- Via Instalação local:
  - Instale o PHP na versão 8.1.3;
  - Instale o MySQL na versão 8.0.18;
- Conecte ao banco de dados e crie um usuário e um schema para a aplicação;
- Configure a conexão do banco de dados no arquivo ".env" com o usuário e schema criados na etapa anterior;
- Abra o CMD na raiz do projeto (caso esteja rodando no Docker, acesse pelo container) e execute os comandos:
  - php artisan migrate
  - php artisan db:seed
- Acesse o endereço do projeto e faça login com usuário "admin@admin.com" e senha "admin";