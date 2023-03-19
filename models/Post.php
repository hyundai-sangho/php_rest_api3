<?php

class Post
{
  // DB stuff
  private $conn;
  private $table = 'posts';

  // Post Properties
  public $id;
  public $categoryId;
  public $categoryName;
  public $title;
  public $body;
  public $author;
  public $createdAt;

  // Constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Get Posts
  public function read()
  {
    // Select Query"
    $query = "SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
              FROM
                $this->table p
              LEFT JOIN
                categories c ON p.category_id = c.id
              ORDER BY
                p.created_at DESC
              ";

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Get Single Post
  public function read_single()
  {
    // Select Query"
    $query = "SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
              FROM
                $this->table p
              LEFT JOIN
                categories c ON p.category_id = c.id
              WHERE
                p.id = ?
              LIMIT 0, 1
              ";

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->id);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set properties
    $this->title = $row['title'];
    $this->body = $row['body'];
    $this->author = $row['author'];
    $this->categoryId = $row['category_id'];
    $this->categoryName = $row['category_name'];
  }

  // Create Post
  public function create()
  {
    // Insert query
    $query = "INSERT INTO $this->table
              SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
              ";

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    // xss 공격 방지 => htmlspecialchars, strip_tags
    $this->title =  htmlspecialchars(strip_tags($this->title));
    $this->body =  htmlspecialchars(strip_tags($this->body));
    $this->author =  htmlspecialchars(strip_tags($this->author));
    $this->categoryId =  htmlspecialchars(strip_tags($this->categoryId));

    // Bind data
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':body', $this->body);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':category_id', $this->categoryId);
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // 뭔가 잘못되면 에러 출력
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Update Post
  public function update()
  {
    // Update query
    $query = "UPDATE $this->table
              SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
              WHERE
                id = :id
              ";

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    // xss 공격 방지 => htmlspecialchars, strip_tags
    $this->title =  htmlspecialchars(strip_tags($this->title));
    $this->body =  htmlspecialchars(strip_tags($this->body));
    $this->author =  htmlspecialchars(strip_tags($this->author));
    $this->categoryId =  htmlspecialchars(strip_tags($this->categoryId));
    $this->id =  htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':body', $this->body);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':category_id', $this->categoryId);
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // 뭔가 잘못되면 에러 출력
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Delete Post
  public function delete()
  {
    // Delete query
    $query = "DELETE FROM $this->table WHERE id = :id";

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    // xss 공격 방지 => htmlspecialchars, strip_tags
    $this->id =  htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // 뭔가 잘못되면 에러 출력
    printf("Error: %s.\n", $stmt->error);

    return false;
  }
}
