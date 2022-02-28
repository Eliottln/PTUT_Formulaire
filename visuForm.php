<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/vue_form/sendMyResponse.php");

if (empty($_SESSION['user']) || empty($_SESSION['user']['id'])) {
    header('Location: index.php');
    exit();
}

if (empty($_GET['identity'])) {

    header("Location: visuAllForms.php");
    exit();
} else if (empty($_GET['page'])) {
    $_GET['page'] = 1;
}

//Protect if come back on this page
if (!empty($_SESSION['page']) && $_SESSION['page'] > $_GET['page']) {
    $_SESSION['nb_question'] = $connect->query("SELECT count(*)
                            FROM Question as Q
                            WHERE Q.id_page < " . $_SESSION['page'])->fetchColumn();
}

$_SESSION['page'] = $_GET['page'];

$form = new VueForm($connect, $_GET['identity'], $_GET['page']);

if (!empty($_POST)) {
    $notLastPage = !empty(($_GET['page'] - 1) < $form->getNBPage());
    sendMyResponse($connect, $_POST, $notLastPage);

    if ($notLastPage) {
        header("Location: visuForm.php?identity=" . $_GET['identity'] . "&page=" . $_GET['page']);
        exit();
    } else {
        header("Location: visuAllForms.php");
        exit();
    }
}


if ($form->getError()) {
    $_SESSION['formNotFound'] = true;
    $_SESSION['formNotFoundID'] = $_GET['identity'];
    header("Location: visuAllForms.php");
    exit();
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

    <main id="VisuForm">

        <a class="buttonBack" href="/visuAllForms.php">&laquo; retour vers tous les forms</a>

        <div id="page">

            <div>
                <progress max="<?= $form->getNBPage() ?>" value="<?= $form->getPage() ?>"></progress>
            </div>

            <div>
                <h2><?= $form->getTitle() ?></h2>
            </div>

            <div>
                <h3><?= 'by ' . $form->getOwner() ?></h3>
            </div>

            <?= $form->toString() ?>

        </div>

    </main>

    <?php require 'modules/footer.php'; ?>

</body>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    function rangeCounter(id) {
        let value = document.getElementById(id).value;
        document.getElementById(id + "-counter").innerHTML = value;
    }
    document.querySelectorAll("input[type='range']").forEach(
        range => range.addEventListener("change", rangeCounter.bind(
            null, range.id))
    );

    let tabNotComplete = []

    function checkIfIsComplete() {
        tabNotComplete = []
        let checkboxList = document.querySelectorAll('div.checkbox-group[required]')
        let RadioList = document.querySelectorAll('div.radio-group[required]')
        let inputRequiredList = document.querySelectorAll('div[id^="question-"] input[required]')
        let n = 0
        
        //checkbox required
        for (let index = 0; index < checkboxList.length; index++) {
            let ChecklistLength = checkboxList[index].children.length

            for (let i = 0; i < ChecklistLength; i++) {
                
                if(checkboxList[index].children[i].firstElementChild.checked){
                    n++
                }
                
            }
            
            if (n < 1) {
                tabNotComplete.push(checkboxList[index].parentElement)
                return false;
            }
            n = 0
        }
        
        
        //radio required
        for (let index = 0; index < RadioList.length; index++) {
            let RadiolistLength = RadioList[index].children.length

            for (let i = 0; i < RadiolistLength; i++) {
                if(RadioList[index].children[i].firstElementChild.checked){
                    n++
                }
                
            }
            if (n < 1) {
                tabNotComplete.push(RadioList[index].parentElement)
                return false;
            }
            n = 0
        }

        //input required
        for (let index = 0; index < inputRequiredList.length; index++) {

            if(inputRequiredList[index].value == ''){

                tabNotComplete.push(inputRequiredList[index].parentElement)
                return false;
            }
        }

        return true
    }

    function alertUser() {
        for (let index = 0; index < tabNotComplete.length; index++) {
            tabNotComplete[index].firstElementChild.setAttribute('style',
                    "color: red"
                )
            
        }
    }


    document.getElementById('span-submit').addEventListener('click', function() {
        if(checkIfIsComplete()){
            document.getElementById('SubmitButton').removeAttribute('disabled')
        }
        else{
            document.getElementById('SubmitButton').setAttribute('disabled',true)
            alertUser()
        }
        
    })
    checkIfIsComplete()
</script>

</html>