<?php
require "./dbBroker.php";
require "./model/prijava.php";

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$result = Prijava::getAll($conn);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FON: Prijava kolokvijuma</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
</head>

<body>
    <div class="container">
        <div class="row md-1">
            <form action="obrada.php" method="post">
                <button type="submit" name="submit" value="log_out" class="btn btn-warning btn-block">Log out</button>
            </form>
        </div>
        <!-- Header section -->
        <div class="jumbotron text-center">
            <h1>Prijava Kolokvijuma</h1>
            <p>Fakultet organizacionih nauka</p>
        </div>


        <div class="row mb-4 text-center">
            <div class="col-md-4 col-md-offset-4">
                <button id="btn-dodaj" type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#myModal">Zakazi kolokvijum</button>
            </div>
        </div>

        <!-- Table section -->
        <div id="pregled" class="panel panel-success">
            <div class="panel-body">
                <form id="prijavaForm" action="obrada.php" method="post">
                    <table id="myTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Predmet</th>
                                <th>Katedra</th>
                                <th>Sala</th>
                                <th>Datum</th>
                                <th>Selektuj</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0) { // Provera da li postoje podaci 
                            ?>
                                <?php while ($red = $result->fetch_array()) { ?>
                                    <tr>
                                        <td><?php echo $red["predmet"] ?></td>
                                        <td><?php echo $red["katedra"] ?></td>
                                        <td><?php echo $red["sala"] ?></td>
                                        <td><?php echo $red["datum"] ?></td>
                                        <td>
                                            <label class="custom-radio-btn">
                                                <input type="radio" name="id_predmeta" value="<?php echo $red['id']; ?>">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else {
                            ?>
                                <tr>
                                    <td colspan="5" class="text-center">Nema unetih kolokvijuma</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <!-- Dugmad za akcije na dnu -->
                    <div class="row">
                        <div class="col-md-6">
                            <button id="btn-izmeni" type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#izmeniModal" disabled>Izmeni</button>
                        </div>
                        <div class="col-md-6">
                            <button id="btn-obrisi" type="submit" name="submit" value="Obrisi" class="btn btn-danger btn-block" disabled>Obrisi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Zakazi Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title text-center">Zakazi kolokvijum</h3>
                    </div>
                    <div class="modal-body">
                        <form action="obrada.php" method="post" id="dodajForm">
                            <div class="form-group">
                                <label>Predmet</label>
                                <input type="text" name="predmet" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Katedra</label>
                                <input type="text" name="katedra" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Sala</label>
                                <input type="text" name="sala" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Datum</label>
                                <input type="date" name="datum" class="form-control" required>
                            </div>
                            <button type="submit" name="submit" value="zakazi" class="btn btn-success btn-block">Zakazi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Izmeni Modal -->
        <div class="modal fade" id="izmeniModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title text-center">Izmeni kolokvijum</h3>
                    </div>
                    <div class="modal-body">
                        <form action="obrada.php" method="post" id="izmeniForm">
                            <input id="id_predmeta" type="hidden" name="id_predmeta" readonly>
                            <div class="form-group">
                                <label>Predmet</label>
                                <input id="predmet" type="text" name="predmet" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Katedra</label>
                                <input id="katedra" type="text" name="katedra" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Sala</label>
                                <input id="sala" type="text" name="sala" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Datum</label>
                                <input id="datum" type="date" name="datum" class="form-control" required>
                            </div>
                            <button type="submit" name="submit" value="izmeni" id="btnIzmeniModal" class="btn btn-success btn-block">Izmeni</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
        // Omogućavanje dugmadi kada je selektovan radio button
        $('input[name="id_predmeta"]').on('change', function() {
            // Omogućavamo dugmad "Izmeni" i "Obriši" nakon selektovanja
            $('#btn-izmeni').prop('disabled', false);
            $('#btn-obrisi').prop('disabled', false);

            // Pronalazimo selektovani red u tabeli
            let selectedRow = $(this).closest('tr');

            // Uzimamo podatke iz selektovanog reda
            let predmet = selectedRow.find('td:eq(0)').text();
            let katedra = selectedRow.find('td:eq(1)').text();
            let sala = selectedRow.find('td:eq(2)').text();
            let datum = selectedRow.find('td:eq(3)').text();

            // Uzimamo vrednost iz selektovanog radio dugmeta (id predmeta)
            let id = $(this).val();

            // Postavljamo vrednosti u modal (u ovom slučaju za polje id)
            $('#id_predmeta').val(id); // Postavlja vrednost ID-a u hidden input ili modal
            $('#predmet').val(predmet);
            $('#katedra').val(katedra);
            $('#sala').val(sala);
            $('#datum').val(datum);
        });
    </script>
</body>

</html>
