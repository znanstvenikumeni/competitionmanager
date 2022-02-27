<?php

class Component {
  public const PATH_COMPONENTS = __DIR__.'/../../../views/components/';

  public static function render($namespace, $component) {
    if (preg_match('/[^a-zA-Z0-9]/', $namespace) !== 0) {
      throw new Exception('Namespace can only contain characters matching this group: [a-zA-Z0-9]');
    }

    $namespacePath = self::PATH_COMPONENTS . $namespace;

    $namespaceManifest = file_get_contents($namespacePath . '/manifest.json');
    if (!$namespaceManifest) {
      throw new Exception('Namespace manifest not found');
    }

    $namespace = json_decode($namespaceManifest);
    if (!$namespace || !$namespace->components) {
      throw new Exception('Malformed namespace manifest');
    }
    
    $componentFilename = $namespace->components->$component;

    if (!$componentFilename) {
      throw new Exception('Component not registered in namespace manifest.');
    }

    if (preg_match('/[^a-zA-Z0-9.]/', $componentFilename) !== 0) {
      throw new Exception('Component filename can only contain characters matching this group: [a-zA-Z0-9.]');
    }

    if (stripos($componentFilename, ".php") !== false) {
      include "{$namespacePath}/{$componentFilename}";
      return;
    }

    $componentFile = file_get_contents("{$namespacePath}/{$componentFilename}");
    return $componentFile;
  }
}