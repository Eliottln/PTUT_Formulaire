<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/include/includeDATABASE.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/vue_form/sendMyResponse.php");

if (empty($_GET['identity'])) {

    header("Location: visuAllForms.php");
    exit();
} else if (empty($_GET['page'])) {
    $_GET['page'] = 1;
}

$form = new VueForm($connect, $_GET['identity'], $_GET['page']);

if (!empty($_POST)) {
    $notLastPage = !empty(($_GET['page'] - 1) < $form->getNBPage());
    sendMyResponse($connect, $_POST,$notLastPage);

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
                <h1><?= '#' . $form->getID() ?></h1>
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
        console.log(id);
        let value = document.getElementById(id).value;
        document.getElementById(id + "-counter").innerHTML = value;
    }
    document.querySelectorAll("input[type='range']").forEach(
        range => range.addEventListener("change", rangeCounter.bind(
            null, range.id))
    );

    function checkIfIsComplete(){

        let checkboxList = $('div.checkbox-group.required')
        let RadioList = $('div.radio-group.required')
        let inputRequiredList = $('div[id^="question-"] input[required]')

        let n=0

        checkboxList.each(function(){
            if($(this).find(':checkbox:checked').length > 0){
                n++
            }
        })

        if(checkboxList.length > n){
            $('#S').attr('disabled',true);
            return false
        }
        n=0

        RadioList.each(function(){
            if($(this).find(':radio:checked').length > 0){
                n++
            }
        })

        if(RadioList.length > n){
            $('#S').attr('disabled',true);
            return false
        }
        n=0

        inputRequiredList.each(function(){
            if($(this).val().length > 0){
                n++
            }
        })
        
        if(inputRequiredList.length > n){
            $('#S').attr('disabled',true);
            return false
        }

        $('#S').removeAttr('disabled');
        return true
    }

    function alertUser(){
        $('div.checkbox-group.required').each(function(){
            if($(this).find(':checkbox:checked').length <= 0){
                $(this).parent().first().css({color: "red"})
            }
        })
        $('div.radio-group.required').each(function(){
            if($(this).find(':checkbox:checked').length <= 0){
                $(this).parent().first().css({color: "red"})
            }
        })
        let requiredList = document.querySelectorAll('input[required]')
        for (let index = 0; index < requiredList .length; index++) {
            if(requiredList[index].value == '' || requiredList[index].value == undefined){
                requiredList[index].parentNode.firstElementChild.style.color = "red"
            }
        }
        console.log('ok')
    }

    let inputList = document.querySelectorAll('div[id^="question-"] input');
    
    inputList.forEach( input => input.addEventListener('click',checkIfIsComplete))
    document.getElementById('span-submit').addEventListener('click',function(){
        if (this.parentElement.disabled) {
            alertUser()
        }
        
    })
    checkIfIsComplete()
</script>

</html>