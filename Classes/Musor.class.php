<?

class Musor {
    public $Id = '';
    public $feldolgozva = false;
    private $db;

    public function __construct($musor_id) {
        $this->Id = $musor_id;
        $this->db = new DB();
    }
    
    public function getFeldolgozva() {
        return $this->feldolgozva;
    }

    public function setFeldolgozva($feld) {
        $this->feldolgozva = $feld;
    }
    
    public function storeFeldolgozva() {
        $this->db->update("musor", array("feldolgozva"=>$this->feldolgozva), array("musor_id"=>$this->Id));
    }

}

?>