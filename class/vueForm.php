<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/vue_form/getChoicesArray.php");

class VueForm
{

    private $pdo;

    private $id;
    private string $title;
    private $ownerID;
    private string $owner;

    private array $questions;

    private bool $error;

    function __construct($connect, $id)
    {

        $this->error = false;

        $this->pdo = $connect;
        $this->id = $id;

        if ($this->getFormDATA()) {
            $this->questions = array();
            $this->getQuestionsDATA();
        } else {
            $this->error = true;
        }
    }

    private function getFormDATA(): bool
    {
        $date = $this->pdo->quote(date("Y-m-d"));
        $_data = $this->pdo->query("SELECT f.title, f.id_owner, u.name, u.lastname 
                                        FROM Forms as f 
                                        INNER JOIN Users as u ON f.id_owner = u.id 
                                        WHERE f.id = " . $this->id . " 
                                        AND (expire >= " . $date . " OR expire = '')")->fetch() ?? NULL;

        if ($_data) {
            $this->title = $_data['title'];
            $this->ownerID = $_data['id_owner'];
            $this->owner = $_data['name'] . " " . $_data['lastname'];
            return true;
        }
        return false;
    }

    private function getQuestionsDATA()
    {

        try {

            $_questions = $this->pdo->query("SELECT id,type,title,required, min, max,format 
                                            FROM Questions 
                                            WHERE id_form = " . $this->id)->fetchAll();

            $_choices = $this->pdo->query("SELECT * 
                                        FROM Choices 
                                        WHERE id_form = " . $this->id)->fetchAll();

            $i = 1;
            foreach ($_questions as $value) {

                switch ($value['type']) {
                    case 'radio':
                        array_push($this->questions, $this->addRadio($i, $value['title'], getChoicesArray($value['id'], $_choices)));
                        break;
                    case 'checkbox':
                        array_push($this->questions, $this->addCheckbox($i, $value['title'], getChoicesArray($value['id'], $_choices)));
                        break;
                    case 'select':
                        //TODO
                        break;

                    case 'range':
                    case 'number':
                        array_push($this->questions, $this->addQuestion($i, $value['title'], $value['type'], $value['min'], $value['max']));
                        break;

                    case 'date':
                        array_push($this->questions, $this->addQuestion($i, $value['title'], $value['type'], $value['format']));
                        break;

                    default:
                        array_push($this->questions, $this->addQuestion($i, $value['title'], $value['type']));
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
    }

    public function getError()
    {
        return $this->error;
    }

    private function addCheckbox($_id, $_title, array $_RadioChoices):string{
        $resultat =  '<div id="question-'. $_id .'-radio">
                            <label class="questionTitle">' . $_title . '</label>
                            <div >';
    
        foreach ($_RadioChoices as $choice) {
            $resultat .= '<div class="checkboxVisuForm"> 
                                <input name="question-'. $_id .'[]" value="'. strtolower($choice['description']) .'" type="checkbox" id="question-'. $_id .'-'. $choice['id'].'" >
                                <label for="question-'. $_id .'-'. $choice['id'].'"> '. $choice['description'] .'</label>
                          </div>   ';
        }
    
        $resultat .= '    </div>
                    </div>';
    
        return $resultat;
    }

    private function addRadio($_id, $_title, array $_RadioChoices):string{
        $resultat =  '<div id="question-'. $_id .'-radio">
                            <label class="questionTitle">' . $_title . '</label>
                            <div>';
    
        foreach ($_RadioChoices as $choice) {
            $resultat .= '<div> 
                                <input class="radio" name="question-'. $_id .'" value="'. strtolower($choice['description']) .'" type="radio" id="question-'. $_id .'-'. $choice['id'].'" >
                                <label for="question-'. $_id .'-'. $choice['id'].'"> '. $choice['description'] .'</label>
                          </div>   ';
        }
    
        $resultat .= '    </div>
                    </div>';
    
        return $resultat;
    }

    private function addQuestion($_id, $_title, $_type, $option1 = null, $option2 = null):string{

        switch ($_type) {
        case 'range':
            return '<div id="question-' . $_id . '-' . $_type . '">
                        <label for="question-' . $_id . '"  class="questionTitle"> ' . $_title . '</label>
                        <input id="question-' . $_id  . '" type="' . $_type . '" name="question-' . $_id . '" min="' . $option1 . '" max="' . $option2 . '" value="' . $option1 . '" required>
                        <span id="question-' . $_id  . '-counter">' . $option1 . '</span>
                    </div>';
        case 'number':
            return '<div id="question-' . $_id . '-' . $_type . '">
                        <label for="question-' . $_id . '"  class="questionTitle"> ' . $_title . '</label>
                        <input id="question-' . $_id  . '" type="' . $_type . '" name="question-' . $_id . '" min="' . $option1 . '" max="' . $option2 . '" value="' . $option1 . '" required>
                    </div>';

        case 'date':
            if($option1 == "duration"){
                return '<div id="question-' . $_id . '-' . $_type . '">
                            <label for="question-' . $_id . '"  class="questionTitle"> ' . $_title . '</label>
                            <p>Du </p>
                            <input id="question-' . $_id  . '-1" type="datetime-local" name="question-' . $_id . '" required>
                            <p>Du </p>
                            <input id="question-' . $_id  . '-2" type="datetime-local" name="question-' . $_id . '" required>
                        </div>';
            }
            return '<div id="question-' . $_id . '-' . $_type . '">
                        <label for="question-' . $_id . '"  class="questionTitle"> ' . $_title . '</label>
                        <input id="question-' . $_id  . '" type="' . $option1 . '" name="question-' . $_id . '" required>
                    </div>';

        default:
            return '<div id="question-' . $_id . '-' . $_type . '">
                        <label for="question-' . $_id . '"  class="questionTitle"> ' . $_title . '</label>
                        <input id="question-' . $_id  . '" type="' . $_type . '" name="question-' . $_id . '" required>
                    </div>';
        }
    }

    public function getID() {
        return $this->id;
    }

    public function getTitle():string {
        return $this->title;
    }

    public function getOwner():string {
        return $this->owner;
    }

    public function toString() {
        $string = "";
        $string .= '<form action="/visuForm.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="formID" value="' . $this->id . '">
                        <input type="hidden" name="ownerID" value="' . $this->ownerID . '">';
  
        foreach ($this->questions as $question){
            $string .= $question;
        }

        $string .= '<div>
                        <button id="S" class="buttonVisuForm" type="submit">Envoyer</button>
                        <button id="R" class="buttonVisuForm" type="reset">Effacer</button>
                    </div>
                </form>';
        return $string;
    }
    
    
}
