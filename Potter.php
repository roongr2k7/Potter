<?php

class Potter {
  protected $discounted_rate = [1 => 1, 2 => 0.95, 3 => 0.9, 4 => 0.8, 5 => 0.75];
  protected $price = 8;

  function calculatePrice($books) {
    return count($books) * $this->calculateDiscount($books) * $this->price;
  }

  function calculateDiscount($books) {
    $unique_books = array_unique($books);
    $count_unique_books = count($unique_books);
    return $this->discounted_rate[$count_unique_books];
  }

  function groupBooks($books) {
    $group_books  = [];
    while (count($books) > 0) {
      $unique_books = array_unique($books);
      $books = array_values(array_diff_assoc($books, $unique_books));
      $group_books[] = $unique_books;
    }
    return $group_books;
  }

  function chooseLowestPrice($books) {
    $group_books = $this->groupBooks($books);
    $lowest_price = $this->sumPrice($group_books);
    $shouldRun = true;
    while ($shouldRun) {
      $group_books = $this->changeBooksBetweenGroup($group_books);
      $current_price = $this->sumPrice($group_books);
      if ($current_price < $lowest_price) {
        $lowest_price = $current_price;
      }
      $shouldRun = (count($group_books[0]) >= count($group_books[1]));
    }
    return $lowest_price;
  }

  function changeBooksBetweenGroup($group_books) {
    $diff = array_values(array_diff($group_books[0], $group_books[1]));
    if (count($diff) > 0) {
      $group_books[0] = array_diff($group_books[0], [$diff[0]]);
      $group_books[1][] = $diff[0];
      asort($group_books[1]);
      $group_books = [array_values($group_books[0]), array_values($group_books[1])];
    }
    return $group_books;
  }

  function sumPrice($group_books) {
    $price_rate = 0;
    foreach ($group_books as $group) {
      $price_rate += count($group) * $this->calculateDiscount($group);
    }
    return $price_rate * $this->price;
  }
}
