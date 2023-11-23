<?php
namespace Drupal\Store_locator;

 use Drupal\Core\Entity\EntityTypeManagerInterface;

class StoreLocatorService{
  protected EntityTypeManagerInterface $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entityTypeManager)
  {
    $this->entityTypeManager = $entityTypeManager;
  }

  Public function getJsonFileContent($path = 'public://csvjson.json'){

    $content = file_get_contents($path);
    return json_decode($content,TRUE);
  }
}
