<?php 
namespace source\Models\Reviews; 

use Source\Core\Model; 
use Source\Core\Connect; 

class Review extends Model { 
    private ?int $id; 
    private ?int $userId; 
    private ?int $portfolioId; 
    private ?string $evaluate; 
    
public function __construct( 
    ?int $id = null, 
    ?int $userId = null, 
    ?int $portfolioId = null, 
    ?string $evaluate = null 
){ 
    $this->id = $id; 
    $this->userId = $userId; 
    $this->portfolioId = $portfolioId; 
    $this->evaluate = $evaluate; 
    
    $this->table = 'reviews'; 
    $this->primaryKey = 'id'; 
    $this->fillable = ['userId', 'portfolioId', 'evaluate']; 
} 

public function getId():?int 
{ 
    return $this->id; 
} 

public function setId(?int $id = null):void 
{ 
    $this->id = $id; 
} 


public function getUserId():?int 
{ 
    return $this->userId; 
}

public function setUserId(?int $userId):void 
{ 
    $this->userId = $userId; 
} 


public function getPortfolioId():?int 
{ 
    return $this->portfolioId; 
} 

public function setPortfolioId(?int $portfolioId):void 
{ 
    $this->portfolioId = $portfolioId; 
} 


public function getEvaluate():?string 
{ 
    return $this->evaluate; 
} 

public function setEvaluate(?string $evaluate):void 
{ 
    $this->evaluate = $evaluate; 
} 

}

