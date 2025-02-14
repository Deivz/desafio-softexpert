<p align="center">
<img src="https://github.com/user-attachments/assets/df8f539c-3153-4a50-84d4-0efa8ebc2342" alt="Logo do Sistema" />
</p>

# Desafio técnico SoftExpert

Repositório criado para o desafio técnico a ser realizado para vaga de Desenvolvedor na empresa SoftExpert.


### Prévia do layout da página em desktop
<img src="https://github.com/user-attachments/assets/b9aa1ee4-7486-4f8c-8bc6-f41dd1366ba4" alt="Imagem do projeto rodando em um browser desktop" />


### Layout da página em dispositivos mobile
<img src="https://github.com/user-attachments/assets/f834a4c5-e389-4e55-81f4-591ae3887127" alt="Imagem do projeto rodando em um browser mobile" />


## No que consiste o desafio

Implementar um sistema de um mercado conforme lista de requisitos, sendo eles:

- Deve ser desenvolvido em PHP vanilla; :heavy_check_mark:
- Cadastrar produtos; :heavy_check_mark:
- Cadastrar os tipos dos produtos; :heavy_check_mark:
- Cadastrar valores dos percentuais de impostos incididos nos tipos de produto; :heavy_check_mark:
- A tela de venda deverá informar os produtos e as quantidades adquiridas; :heavy_check_mark:
- O sistema deve apresentar o valor de cada item multiplicado pela quantidade adquirida e a quantidade paga de imposto em cada item, um totalizador do valor da compra e um
totalizador do valor dos impostos; :heavy_check_mark:
- A venda deverá ser salva; :heavy_check_mark:
- Utilizar POSGRESQL ou MSSQL Server; :heavy_check_mark:
- Opcional: usar algum framework ou biblioteca para a construção do front-end; :heavy_check_mark:
- Utilização de design patterns (utilizado Strategy e DAO); :heavy_check_mark:
  
  
<br />
<br />


## Tecnologias e ferramentas utilizadas
### `PHP 8.2 Vanilla`
Um dos requisitos para o teste técnico era a utilização de PHP sem nenhum tipo de framework, podendo-se utilizar de algumas bibliotecas.

### `Composer`
Para fazer uso do autoload, bem como gerenciamento de pacotes.

### `PHP Unit`
Testes de unidade e de integração foram implementados e realizados utilizando esta ferramenta.

### `JavaScript vanilla`
Para validação de dados no front-end, bem como realização das requisições através de AJAX, foi utilizado JS puro.

### `Bootstrap`
Para implementação das views foi utilizado a biblioteca Bootstrap, por conta de sua simplicidade e facilidade na implementação.

### `POSTGRESQL`
O banco de dados escolhido para este projeto foi o POSTGRESQL, uma vez que era uma das escolhas possíveis por conta do requisito, era o SGBD de minha maior afinidade, 
além de ser gratuito.


## Decisões de projeto
### `Arquitetura`
- Optei por um estilo arquitetural baseado em camadas, sendo o padrão arquitetural escolhido o MVC, por conta da facilidade na
implementação e manutenibilidade.

### `Rotas extras`
- Apesar de não ter sido solicitado, implementei uma rota extra para edição de Tipos de Produto e exclusão de Impostos, para fins didáticos e também para realização de alguns testes.

### `Soft Delete`
- Apesar de também não ter sido solicitado, com a rota extra de exclusão optei por implementar no banco o sistema de Soft Delete, onde apenas coloca-se uma "flag" para sinalizar
que aquele item foi excluído, para casos de futuras necessidades de recuperação de informações.

### `Paginação`
- Para fins didáticos e de boa prática, implementei paginação na exibição dos dados no front-end.

## Pontos de melhoria
### Implementação de Containers DI ou padrão de design Factory
- Como o projeto não tinha uma previsão de escala, optei por instanciar os controladores manualmente. Antes eles eram identificados conforme rota acessada. Entretanto, quando
algum controlador precisava receber algum parâmetro diferente no construtor passou a existir um acomplamento maior, dificultando a implementação dos testes. Algumas das formas
de contornar esta situação seria utilizando containers de injeção de dependências ou utilizar o padrão de projeto Factory.

## Desafios, dificuldades e superação
- Apesar de ser um sistema relativamente simples, a implementação dele trouxe alguns desafios. Desde a implementação da arquitetura e utilização dos design patterns, bem como 
com a implementação dos testes de integração. Também tive que passar por uma situação a qual não tenho costume: devido a implementação da paginação e pelo fato da tabela de Taxas
conter mais de um item para cada tipo de produto, tive que contornar o comportamento padrão que é implementar diretamente o limit/offset na tabela de consulta.
- A implementação de sistemas sem frameworks também é um desafio bastante prazeroso, uma vez que não temos as facilidades já trazidas por eles, tendo que criar a própria solução
para contornar problemas complexos.

## Conclusão
Acredito ter atendido todos os requisitos solicitados e tem sido bastante gratificante participar deste processo seletivo. Implementar um sistema todo em linguagens vanilla, sem 
utilização de frameworks, é bastante desafiador e gratificante. Pude por em prática meus conhecimentos de testes de unidade e de integração, design patterns e arquitetura. Termino 
esta etapa com um sentimento de dever cumprido!


### Instalação do projeto

## Iniciando o projeto

Clonar reste repositório e utilizar o comando abaixo para fazer o download das dependências:

### `composer install`

É preciso também ter um .env configurado na raiz do projeto, uma vez que os dados do BD bem como os nomes das tabelas são coletados de lá. 
As informações que precisam estar contidas são:

- DB_HOST
- DB_ID
- DB_PORT
- DB_PASS
- DB_USER
- DB_NAME
- TABLE_PRODUCTS
- TABLE_PRODUCT_TYPES
- TABLE_TAXES
- TABLE_SALES

A conexão é passada pras classes que a utilizarão através de injeção de dependência da interface PDO, caso seja necessário pode-se somente 
mudar o ConnectionController para a realização da conexão de sua preferência.

Em seguida acessar a pasta public, onde esta contido o "entry point" do projeto. Pode-se iniciar o projeto através do comando no terminal:

### `php -S localhost:8080`

Outro ponto importante, alguns dos testes para serem realizados precisam que o servidor do PHP esteja rodando.

Muito obrigado!
