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
            Sig Chamados
        </title>
    </head>
    <body>
        <p>
        <?php
        
            $get_area = $us->getArea();
            $file_area = __DIR__ . DS . "system" . DS . $get_area . ".php";
            
            if(!$us->usuarioLogado()){ ?>
                <h2>Faça seu cadastro para adicionar novos chamados</h2>

                <form id="form_login" action="acesso.php" method="post" >
                    <p><label for="nome">Nome: <input type="text" name="Nome" id="nome" placeholder="Digite seu nome" /></label></p>
                    <p><label for="email">Email: <input type="text" name="email" id="email" placeholder="Digite seu email" /></label></p>
                    <p><label for="senha">Senha: <input type="password" name="senha" id="senha" placeholder="Digite sua senha" /></label></p>

                    <p><input type="submit" name="entrar" value="Entrar" /></p>
                </form>
                <?php  
                echo "<p>Já possui uma conta? <a href='{$us->url}acesso.php?a=login' >Acessar</a></p>";
            }
            elseif(file_exists($file_area)){
                include($file_area);
            }
            else{
                echo $us->getAbout();
            }
        ?>            
        </p>
    </body>
</html>

