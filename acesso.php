<?php include("./system/config.php");
    $us = new Usuarios();
  
  ?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <!-- <link rel="stylesheet" type="text/css" href="" /> -->
        <script type="text/javascript" src="<?=$us->url_js?>funcoes.js"></script>
        <title>
            Sig Chamados - Acessar o sistema
        </title>
    </head>
    <body>
       
        <h2>Faça o login para acessar o sistema</h2>
        <?php
            $acesso = $us->urlGetVal("a");
            var_dump($_SESSION);
            if(isset($_POST['logar']) == 1 && !empty($_POST['email']) && !empty($_POST['senha'])){
                if(!$us->logar($_POST['email'],$_POST['senha'])){                    
                    echo "<p>Email ou senha inválidos!</p>";
                }
            }
            if(!$us->usuarioLogado()){
            ?>
            <form id="form_login" action="acesso.php" method="post" >
                <input type="hidden" name="logar" id="logar" value="1" />
                <p><label for="email">Email: <input type="text" name="email" id="email" placeholder="Digite seu email" /></label></p>
                
                <p><label for="senha">Senha: <input type="password" name="senha" id="senha" placeholder="Digite sua senha" /></label></p>
                
                <p><input type="submit" name="entrar" value="Entrar" /></p>
            </form>
                
            
            <?php
            }
            else{
                header("Location: {$us->url}");
            }
        ?>            
        
    </body>
</html>

