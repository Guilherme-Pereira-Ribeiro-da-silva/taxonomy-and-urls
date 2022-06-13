# Taxonomy and urls Plugin

Plugin que permite ao usuário criar suas próprias taxonomias
e definir as urls para os posts que as contém.

**Autor:** [Guilherme Pereira](https://github.com/Guilherme-Pereira-Ribeiro-da-silva/) 

**Versão:** 1.0.1

##  Requerimentos
Para utilizar este plugin, você também precisará 
instalar o plugin: 
+[WPMVC](https://github.com/tombenner/wp-mvc)

## Instalação

Após haver cumprido os requerimentos, vá até pelo terminal até a pasta de plugins
da sua aplicação wordpress e execute o comando:

	git clone https://github.com/Guilherme-Pereira-Ribeiro-da-silva/taxonomy-and-urls.git

## Como o projeto foi organizado
O projeto foi desenvolvido utilizando o padrão MVC, possuíndo
a seguinte estrutura de pastas:
```bash
├───app #cógigo do projeto
│   ├───config #configurações dos arquivos
│   ├───controllers #controllers da aplicação
│   │   └───admin #controllers da aba administrativa
│   ├───models #models da aplicação
│   ├───public #css e js do projeto
│   │   ├───css
│   │   └───js
│   └───views #templates das páginas do usuário
│       └───admin #templates da aba administrativa
│           ├───taxonomies #templates do controller das taxonomias
│           └───urls #templates do controller das urls
├───loaders #classes que criam as rewrite rules e setam os redirects
└───vendor #composer
    └───composer
```   
## Como utilizar
[Vídeo de instruções](https://www.youtube.com/watch?v=02SsPZwtQTU)

## Modelagem do banco de dados
Basicamente o plugin cria duas tabelas (taxonomias e urls).

![diagrama-do-banco-de-dados](https://github.com/Guilherme-Pereira-Ribeiro-da-silva/taxonomy-and-urls/blob/main/app/public/modelo-relacional.png)

A tabela de taxonomias é responsável por guardar as informações
das taxonomias para que estas possam ser carregadas.

Já a tabela de urls é responsável por setar o sufixo o correspondente
à taxonomia. 

Por exemplo, um post com o termo sao-paulo(da taxonomia notícias)
e com o sufixo noticias, será gerado na url: https://dominio/sao-paulo/noticias/nome-do-post

## Observações do autor
Se você descobriu algum bug, acha que alguma funcionalidade
pode ser adicionada ou que algum código pode ser melhorado,
não deixe de entrar em contato comigo pelo email guinovembro43@gmail.com.
Eu estarei mais do que feliz em melhorar este sistema enquanto
aprendo novas tecnologias!
