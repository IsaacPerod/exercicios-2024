<?php

namespace Chuva\Php\WebScrapping\Entity;

/**
 * Paper Author personal information.
 */
class Person{

  /**
   * Person name.
   */
  public string $name;

  /**
   * Person institution.
   */
  public string $institution;

  /**
   * Get the name of the author.
   *
   * @return string The name of the author.
   */
  public function getName(): string{
    return $this->name;
  }

  /**
   * Get the institution of the author.
   *
   * @return string
   */
  public function getInstitution(): string{
    return $this->institution;
  }

  /**
   * Builder for the class Person.
   *
   * @param string $name The nome of author.
   * @param string $institution The institution of author.
   */
  public function __construct(string $name, string $institution) {
      $this->name = $name;
      $this->institution = $institution;
  }

}
