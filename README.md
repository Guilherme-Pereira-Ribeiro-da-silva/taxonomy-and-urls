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

## Rotas

Para verificar a rota da api, por favor visite:

[rotas wp regioes](https://www.postman.com/guilhermepereiraribeiro/workspace/api-wp-regioes)

## Diagramas

### Diagrama de classes
![diagrama-de-classes](https://github.com/Guilherme-Pereira-Ribeiro-da-silva/taxonomy-and-urls/blob/main/diagramas/diagrama_de_classes.png)

O diagrama de classes acima especifíca as classes criadas 
durante o projeto. De um lado temos os loaders das taxonomias e das urls, 
que se relacionam com a classe geral de loaders por meio de
uma relação de herança.

Já por outro lado, temos as relações entre os models e os controllers. 
Entre tais, a relação é de 1 para 1, uma vez que para cada model deve existir 
um controller e vice versa.

## Observações do autor
Se você descobriu algum bug, acha que alguma funcionalidade
pode ser adicionada ou que algum código pode ser melhorado,
não deixe de entrar em contato comigo pelo email guinovembro43@gmail.com.
Eu estarei mais do que feliz em melhorar este sistema enquanto
aprendo novas tecnologias!

#### Uma mensagem ao time da seox:
Muito obrigado por me introduzir a este novo desafio. Como eu já havia 
dito, me encanta aprender coisas novas e sempre fazer melhor.
Eu sei que provavelmente quando olharem o meu código, por serem mais
experientes, provavelmente verão coisas passíveis de melhora. Independente
de meu resultado final neste teste e de se eu serei contratado ou não,
eu adoraria receber um feedback de onde posso melhorar e o que devo estudar. Pois de tal forma, posso sempre
melhorar minhas habilidades e meu nível de código.

**Muito obrigado pela oportunidade e espero logo fazer parte da equipe!**
