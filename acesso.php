<?php include("./system/config.php");
    $us = new Usuarios();  
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="<?=$us->url_css?>sigchamados.css" />
        <script type="text/javascript" src="<?=$us->url_js?>jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="<?=$us->url_js?>funcoes.js"></script>
        <title>
            Sig Chamados - Acessar o sistema
        </title>
    </head>
    <body>
        <header>
            <div class="titulo"><?php echo $us->getTitle(); ?></div>
        </header>
        <div class="conteudo">
            <div class="login">
                <h3 class="form_title">Faça o login para acessar o sistema</h3>
                <?php          

                if($_POST['logar'] == '1' && !empty($_POST['email']) && !empty($_POST['senha'])){
                    if(!$us->logar($_POST['email'],$_POST['senha'])){                    
                        echo "<p class='erro'>Email ou senha inválidos!</p>";
                    }
                }            
                elseif($_POST['cadastrar'] == '1' && !empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['senha'])){
                    $us->cadastrarUsuario($_POST['nome'], $_POST['email'], $_POST['senha']);                
                    header("Location: {$url}");
                }

                if(!usuarioLogado()){
                ?>
                <form id="form_login" action="acesso.php" method="post" >
                    <input type="hidden" name="logar" id="logar" value="1" />
                    <p><label for="email"><span>Email: </span><input type="text" name="email" id="email" placeholder="Digite seu email" class="input_text" /></label></p>

                    <p><label for="senha"><span>Senha: </span><input type="password" name="senha" id="senha" placeholder="Digite sua senha" class="input_text" /></label></p>

                    <p><input type="submit" name="entrar" value="Entrar" class="input_button" /></p>
                </form>

                    <?php
                    echo "<p class='text'>Não possui uma conta? <a href='{$us->url}index.php' >Criar conta</a></p>";
                }
                else{
                    header("Location: {$us->url}");
                }
                ?>            
            </div>
        </div>
        <footer>
            
        </footer>
    </body>
</html>

