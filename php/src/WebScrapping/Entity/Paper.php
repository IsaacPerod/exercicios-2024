<?php

namespace Chuva\Php\WebScrapping\Entity;

/**
 * The Paper class represents the row of the parsed data.
 */
class Paper {

  /**
   * Paper Id.
   *
   * @var int The ID of the paper.
   */
  public $id;

  /**
   * Paper Title.
   *
   * @var string The title of the paper.
   */
  public $title;

  /**
   * The paper type (e.g. Poster, Nobel Prize, etc).
   *
   * @var string The type of the paper.
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
   * @return int The ID of the paper.
   */
  public function getId(): int {
    return $this->id;
  }

  /**
   * Get the title of the paper.
   *
   * @return string The title of the paper.
   */
  public function getTitle(): string {
    return $this->title;
  }

  /**
   * Get the type of the paper.
   *
   * @return string The type of the paper.
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
   * 
   * @param int $paperID The ID of the paper.
   * @param string $title The title of the paper.
   * @param string $type The type of the paper.
   * @param \Chuva\Php\WebScrapping\Entity\Person[] $authors The authors of the paper.
   */
  public function __construct($paperID, $title, $type, $authors = []) {
    $this->id = $paperID;
    $this->title = $title;
    $this->type = $type;
    $this->authors = $authors;
  }

}
