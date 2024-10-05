<?php 

    if (
    isset($_POST['id_predmeta']) 
    && $_POST['submit'] == 'izmeni' 
    && isset($_POST['predmet'] ) 
    && isset($_POST['katedra'] )
    && isset($_POST['sala'] )
    && isset($_POST['datum'] ) ) {
        $prijava = new Prijava($_POST['id_predmeta'], $_POST['katedra'],$_POST['predmet'],$_POST['sala'],$_POST['datum']);
        $status = Prijava::update($prijava, $conn);

        if ($status) {
            echo "uspesno dodato";
        } else {
            echo "neuspesno";
            
        }
        
    }

?>