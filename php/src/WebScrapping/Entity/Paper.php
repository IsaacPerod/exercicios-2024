<?php

namespace Chuva\Php\WebScrapping\Entity;

/**
 * The Paper class represents the row of the parsed data.
 */
class Paper {

  /**
   * Paper Id.
   *
   * @var int
   */
  public $id;

  /**
   * Paper Title.
   *
   * @var string
   */
  public $title;

  /**
   * The paper type (e.g. Poster, Nobel Prize, etc).
   *
   * @var string
   */
  public $type;

  /**
   * Paper authors.
   *
   * @var \Chuva\Php\WebScrapping\Entity\Person[]
   */
  public $authors;

  /**
   * Get the ID of the paper.
   *
   * @return int
   */
  public function getId(): int {
    return $this->id;
  }

  /**
   * Get the title of the paper.
   *
   * @return string
   */
  public function getTitle(): string {
    return $this->title;
  }

  /**
   * Get the type of the paper.
   *
   * @return string
   */
  public function getType(): string {
    return $this->type;
  }

  /**
   * Get the authors of the paper.
   *
   * @return \Chuva\Php\WebScrapping\Entity\Person[]
   */
  public function getAuthors(): array {
    return $this->authors;
  }

  /**
   * Builder for the Paper class.
   */
  public function __construct($paperID, $title, $type, $authors = []) {
    $this->id = $paperID;
    $this->title = $title;
    $this->type = $type;
    $this->authors = $authors;
  }

}
