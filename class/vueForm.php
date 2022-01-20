<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/modules/vue_form/getChoicesArray.php");

class VueForm
{
    private $pdo;

    private $id;
    private string $title;
    private $ownerID;
    private string $owner;
    private $page;
    private $nb_page;
    private $pageTitle;

    private array $questions;

    private bool $error;

    function __construct($connect, $id, $page)
    {

        $this->error = false;

        $this->pdo = $connect;
        $this->id = $id;
        $this->page = $page;

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
        $_data = $this->pdo->query("SELECT f.title as 'title', f.id_owner, f.nb_page, u.name, u.lastname, p.title as 'titlePage'
                                        FROM Form as f 
                                        INNER JOIN User as u ON f.id_owner = u.id 
                                        INNER JOIN Page as p ON f.id = p.id_form 
                                        WHERE f.id = " . $this->id . " 
                                        AND (expire >= " . $date . " OR expire = '')
                                        AND p.id = " . $this->page)->fetch() ?? NULL;
        
        if ($_data) {
            $this->title = $_data['title'];
            $this->ownerID = $_data['id_owner'];
            $this->owner = $_data['name'] . " " . $_data['lastname'];
            $this->nb_page = $_data['nb_page'];
            $this->pageTitle = $_data['titlePage'];
            return true;
        }
        return false;
    }

    private function getQuestionsDATA()
    {

        try {
            $_questions = $this->pdo->query("SELECT q.id,q.type,q.title,q.required, q.min, q.max,q.format 
                                            FROM Question as q INNER JOIN 'Page' as p ON q.id_page = p.id
                                            WHERE q.id_form = " . $this->id ." AND p.id = " . $this->page." GROUP BY q.id")->fetchAll();

            $_choices = $this->pdo->query("SELECT c.* 
                                        FROM Choice as c INNER JOIN 'Page' as p ON c.id_page = p.id
                                        WHERE c.id_form = " . $this->id ." AND p.id = " . $this->page ." GROUP BY c.id")->fetchAll();

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

    public function getNBPage(){
        return $this->nb_page;
    }

    public function toString() {
        $string = "";
        $string .= '<form action="/visuForm.php?identity='.$this->id.'&page='.($this->page+1).'" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="formID" value="' . $this->id . '">
                        <input type="hidden" name="ownerID" value="' . $this->ownerID . '">
                        <h4>'.$this->pageTitle.'</h4>';
  
        foreach ($this->questions as $question){
            $string .= $question;
        }

        $string .= '<div>
                        <button id="S" class="buttonVisuForm" type="submit">'.($this-> page == $this->nb_page ? 'Finish' : 'Save and next').'</button>
                        <button id="R" class="buttonVisuForm" type="reset">Effacer</button>
                    </div>
                </form>';
        return $string;
    }
    
    
}
