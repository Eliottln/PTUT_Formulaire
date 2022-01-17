<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");
foreach (glob($_SERVER["DOCUMENT_ROOT"] . "/modules/vue_form/*.php") as $filename) {
    include $filename;
}

if (empty($_GET['identity'])) {

    if (!empty($_POST)) {
        sendMyResponse($connect, $_POST);
    }

    header("Location: visuAllForms.php");
    exit();
}

//!!! GIGA LOURD !!!
$date = $connect->quote(date("Y-m-d"));
$form_data = $connect->query("SELECT id, title, id_owner FROM Forms WHERE id = " . $_GET['identity'] . " AND (expire >= " . $date ." OR expire = '')")->fetch() ?? NULL;

if ($form_data) {
    $form_title = $form_data['title'];
    $owner_data = $connect->query("SELECT name,lastname FROM Users WHERE id = " . $form_data['id_owner'])->fetch() ?? NULL;
    $form_owner = $owner_data['name'] . " " . $owner_data['lastname'];
}
else{
    $_SESSION['formNotFound'] = true;
    $_SESSION['formNotFoundID'] = $_GET['identity'];
    header("Location: visuAllForms.php");
    exit();
}


function displayForm($connect): string
{
    $forms = "";


    try {
        $form_questions = $connect->query("SELECT id,type,title,required, min, max,format FROM Questions 
                                            WHERE id_form = " . $_GET['identity'])->fetchAll();
        $form_choices = $connect->query("SELECT * FROM Choices 
                                            WHERE id_form = " . $_GET['identity'])->fetchAll();

        $i = 1;
        foreach ($form_questions as $value) {

            switch ($value['type']) {
                case 'radio':
                    $forms .= addRadio($i, $value['title'], getChoicesArray($value['id'], $form_choices));
                    break;
                case 'checkbox':
                    $forms .= addCheckbox($i, $value['title'], getChoicesArray($value['id'], $form_choices));
                    break;
                case 'select':
                    //TODO
                    break;

                case 'range':
                case 'number':
                    $forms .= addQuestion($i, $value['title'], $value['type'], $value['min'], $value['max']);
                    break;

                case 'date':
                    $forms .= addQuestion($i, $value['title'], $value['type'], $value['format']);
                    break;

                default:
                    $forms .= addQuestion($i, $value['title'], $value['type']);
                    break;
            }
            $i++;
        }
    } catch (PDOException $e) {
        if (!empty($_SESSION['user']) && $_SESSION['user']['admin'] == 1) {
            echo 'Erreur sql : (line : ' . $e->getLine() . ") " . $e->getMessage();
        } else if (!empty($_SESSION['user']) && $_SESSION['user']['admin'] == 0) {
            echo 'Il semblerait que le formulaire ne soit pas accessible';
        }
    }

    return $forms;
}

?>

<!DOCTYPE html>
<html lang="fr">

<?php
$pageName = "Form " . $_GET['identity'];
include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/head.php");
?>

<body>

    <?php require 'modules/header.php'; ?>

    <main>

        <div>
            <h1><?= 'Formulaire numéro : ' . $_GET['identity'] ?></h1>
        </div>

        <div>
            <h2><?= 'Titre : ' . $form_title ?></h2>
        </div>

        <div>
            <h3><?= 'by ' . $form_owner ?></h3>
        </div>

        <form action="/visuForm.php" method="post" enctype="multipart/form-data">

            <?= '<input type="hidden" name="formID" value="' . $form_data['id'] . '">' .
                '<input type="hidden" name="ownerID" value="' . $form_data['id_owner'] . '">' ?>

            <?= displayForm($connect) ?>
            <div>
                <button id="S" type="submit">Envoyer</button>
                <button id="R" type="reset">Effacer</button>
            </div>
        </form>

    </main>

    <?php require 'modules/footer.php'; ?>

</body>
<script>
    function rangeCounter(id) {
        console.log(id);
        let value = document.getElementById(id).value;
        document.getElementById(id + "-counter").innerHTML = value;
    }
    document.querySelectorAll("input[type='range']").forEach(
        range => range.addEventListener("change", rangeCounter.bind(
            null, range.id))
    );
</script>

</html>