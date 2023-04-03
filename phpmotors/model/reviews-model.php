<?php
// Vehicle reviews uploads model

function addReview($invId, $clientId, $reviewText) {
    $db = phpmotorsConnect();
    $sql = 'INSERT INTO reviews (reviewText, clientId, invId)
            VALUES (:reviewText, :clientId, :invId)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":reviewText", $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(":clientId", $clientId, PDO::PARAM_STR);
    $stmt->bindValue(":invId", $invId, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function updateReview($reviewId, $reviewText) {
    $db = phpmotorsConnect();
    $sql = 'UPDATE reviews 
            SET 
            reviewText = :reviewText
            WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":reviewText", $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(":reviewId", $reviewId, PDO::PARAM_STR);
    // update the data
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function getReviewsByInvId($invId) {
    // Create instance of database connection
    $db = phpmotorsConnect();
    $sql = 'SELECT reviews.*, clients.clientFirstname, clients.clientLastname,
            inventory.invMake, inventory.invModel
            FROM reviews
            INNER JOIN clients 
            ON reviews.clientId = clients.clientId
            INNER JOIN inventory 
            ON reviews.invId = inventory.invId
            WHERE reviews.invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue('invId', $invId, PDO::PARAM_STR);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $reviews;
}

function getReviewsByClientId($clientId) {
    // Create instance of database connection
    $db = phpmotorsConnect();
    $sql = 'SELECT 
            reviews.*, 
            inventory.invMake, inventory.invModel, 
            clients.clientFirstname, clients.clientLastname
            FROM reviews 
            INNER JOIN clients
                ON reviews.clientId = clients.clientId
            INNER JOIN inventory
                ON reviews.invId = inventory.invId   
            WHERE reviews.clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $reviews;
}

function getReviewsByReviewId($reviewId) {
    // Create instance of database connection
    $db = phpmotorsConnect();
    $sql = 'SELECT 
            reviews.*, 
            inventory.invMake, inventory.invModel, 
            clients.clientFirstname, clients.clientLastname
            FROM reviews 
            INNER JOIN clients
                ON reviews.clientId = clients.clientId
            INNER JOIN inventory
                ON reviews.invId = inventory.invId   
            WHERE reviews.reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_STR);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $reviews;
}



function deleteReview($reviewId) {
    // Create instance of database connection
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM reviews 
            WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    return $rowsChanged;
}