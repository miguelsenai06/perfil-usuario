# Desafio 3 — Perfil de Usuário com Banco de Dados

Projeto desenvolvido em PHP e MySQL para realizar autenticação de usuários e mostrar uma página de perfil personalizada.

## Funcionalidades

- Login com usuário e senha cadastrados na tabela `usuarios`.
- Consulta ao banco `exercicio` com `mysqli` e consulta preparada.
- Uso de sessões PHP para controlar o acesso.
- Escolha da cor de fundo na tela de login.
- Exibição do nome e da cor escolhida no perfil.
- Logout com encerramento da sessão.

## Arquivos

| Arquivo | Função |
| --- | --- |
| `15d_login.php` | Formulário de usuário, senha e cor; autenticação no banco de dados. |
| `15d_perfil.php` | Página protegida com saudação e cor de fundo escolhida. |
| `15d_logout.php` | Encerra a sessão e retorna à página de login. |

## Requisitos

- Servidor Apache com PHP e extensão `mysqli` habilitada.
- MySQL em execução.
- Banco de dados `exercicio` com a tabela `usuarios` e usuários previamente cadastrados, conforme a atividade anterior.

## Como executar

1. Coloque os três arquivos PHP na pasta `C:\Apache\htdocs\Assunto_7\15d_desafio3` (ajuste o caminho se seu servidor usar outra pasta).
2. No início de `15d_login.php`, configure as credenciais do MySQL para o seu ambiente. **Não publique a senha do banco no GitHub ou no README.**
3. Inicie o Apache e o MySQL.
4. Acesse no navegador: `http://localhost/Assunto_7/15d_desafio3/15d_login.php`.
5. Entre com um usuário e a senha cadastrados na tabela `usuarios` do banco `exercicio` e selecione uma cor de fundo.
6. Confira o nome e a cor na página de perfil. Clique em **Sair do sistema** para encerrar a sessão.

## Como verificar o funcionamento

- Credenciais válidas devem abrir `15d_perfil.php`.
- Credenciais inválidas devem exibir uma mensagem de erro.
- Abrir `15d_perfil.php` sem estar autenticado deve redirecionar ao login.
- A cor selecionada deve aparecer no fundo do perfil.
- Após o logout, o perfil deve exigir novo login.

## Observações

O sistema utiliza a tabela de usuários criada anteriormente: **não cadastra novos usuários**. A implementação aceita algumas opções comuns de nome da coluna de identificação, mas a tabela precisa conter uma coluna `senha` e um identificador compatível.

A configuração do MySQL depende do computador onde o projeto é executado. O funcionamento final deve ser testado localmente com os usuários já cadastrados.

## Entrega

Conforme o enunciado, envie **somente os três arquivos `.php`**. Este `README.md` é uma documentação complementar e não precisa ser anexado na atividade.
