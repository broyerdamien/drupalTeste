<?php

namespace Drupal\store_locator\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\store_locator\StoreLocatorService;

class StoreLocatorController extends ControllerBase
{

  protected StoreLocatorService $storeLocatorService;

  public function __construct(StoreLocatorService $storeLocatorService)
  {
    $this->storeLocatorService = $storeLocatorService;
  }

  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('store_locator.service')
    );
  }

  public function displayContent(): array
  {
    {
      $jsonContents = $this->storeLocatorService->getJsonFileContent();
      $formatContent = [];
      foreach ($jsonContents as $item) {
        $formatContent[] = [
          'ID' => $item['Store ID'],
          'name' => $item['Name'],
          'adresse' => $item['Address'],
          'mail' => $item['E-Mail'],
        ];
      }
      return [
        '#theme' => 'store_locator_content',
        '#content' => $formatContent,
      ];
    }
  }
}
