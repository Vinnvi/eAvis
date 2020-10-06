<?php

namespace App\Entity;

class AvisSearch {


  /**
   * @var int|null
   */
  private $minNote;

  public function __construct() {
    $this->minNote = 0;
  }

  public function setMinNote(int $minNote): AvisSearch
  {
    $this->minNote = $minNote;
    return $this;
  }

  public function getMinNote(): int
  {
    return $this->minNote;
  }

}

?>
