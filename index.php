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
            Sig Chamados
        </title>
    </head>
    <body>
        <header >
            <div class="perfil"><?php 
                if(usuarioLogado()){
                    echo "<span >{$us->tipo[$us->getTipo()]}: <a href='{$us->url}?area=usuarios&acao=formulario&id={$_SESSION['usuario']['id']}' >{$_SESSION['usuario']['nome']}</a>";
                    echo "<a href='{$us->url}logout.php' title='Sair' class='sair db'>Sair</a></span>";
                }else{
                    echo "<a href='{$us->url}acesso.php' title='Login' class='login db'>Login</a>";
                }
            ?></div>
            <div class="titulo"><?php echo $us->getTitle(); ?></div>
        </header>
        <?php if(usuarioLogado() && $us->getTipo() == 2){ 
            echo "<nav>";
                echo "<ul>";                
                    echo "<li><a href='{$url}' title='Página inicial'>Página inicial</a></li>";
                    echo "<li><a href='{$url}?area=chamados' title='Chamados'>Chamados</a></li>";
                    echo "<li><a href='{$url}?area=usuarios' title='Usuários'>Usuários</a></li>";
                echo "</ul>";
            echo "</nav>";
        }
        ?>
        <div id="conteudo">
        <?php
        
            $get_area = $us->getArea();
            $file_area = __DIR__ . DS . "system" . DS . $get_area . ".php";
          
            echo $us->getMsg();
            
            if(!usuarioLogado()){
                echo $us->getAbout();
                ?>
                <h2 class="form_title">Faça seu cadastro para adicionar novos chamados</h2>

                <form id="form_login" action="acesso.php" method="post" >
                    <input type="hidden" name="cadastrar" id="cadastrar" value="1" />
                    <p><label for="nome"><span>Nome: </span><input type="text" name="nome" id="nome" placeholder="Digite seu nome" required="required" class="input_text" /></label></p>
                    <p><label for="email"><span>Email: </span><input type="text" name="email" id="email" placeholder="Digite seu email" required="required" class="input_text" /></label></p>
                    <p><label for="senha"><span>Senha: </span><input type="password" name="senha" id="senha" placeholder="Digite sua senha" required="required" class="input_text" /></label></p>

                    <p><input type="submit" name="entrar" value="Entrar" class="input_button" /></p>
                </form>
                <?php  
                echo "<p>Já possui uma conta? <a href='{$us->url}acesso.php' >Acessar</a></p>";
            }
            elseif(file_exists($file_area)){
                include($file_area);
            }
            elseif(usuarioLogado() && $us->getTipo() == 1){
                echo $us->getAbout();
                echo "<a href='{$url}?area=chamados' title='Meus chamados' class='bt_meus_chamados'>Meus chamados</a>";
            }
            elseif(usuarioLogado() && $us->getTipo() == 2){
                $ch = new Chamados();
                $ch->lista(1);
            }
            else{
                echo $us->getAbout();   
                echo '<p>A liberação de seus acessos será feita por um funcionário.</p>';
            }
        ?>            
        </div>
        <footer >
            
        </footer>
    </body>
</html>

