<?php

class NConfiguration {

  function load($payload) {
    foreach ($payload as $key => $data) {
      $this->{$key} = $data;
    }
  }

  function toJSON() {
    return json_encode($this);
  }
}

?>