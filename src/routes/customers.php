<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app  = new Slim\App;

//GET ALL CUSTOMERS DO BANCO

$app->get('/api/customers', function(Request $request, Response $response){
    // echo 'O Vlad manja dos paranaue';
    $sql = "SELECT * from customers";

    try{
        // capturar os dados do banco montado no mysql
        $db = new db();
        // conectar
        $db = $db->connect();

        // variavel de uso coringa para query
        $stmt = $db->query($sql); // stmt ele chama de statment ou declaração então né 
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customers);


    } catch (PDOException  $e){
        echo '{"error": {"text":' .$e->getMessage().'}';
    }

});

// PEGAR/CONSULTAR SOMENTE UM DADO

$app->get('/api/customers/{id}', function(Request $request, Response $response){
    
    $id = $request->getAttribute('id');
    $sql = "SELECT * from customers WHERE id = $id";

    try{
        // capturar os dados do banco montado no mysql
        $db = new db();
        // conectar
        $db = $db->connect();

        // variavel de uso coringa para query
        $stmt = $db->query($sql);
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ); // ajustou aqui a variavel customer
        $db = null;
        echo json_encode($customer); // ajustou aqui a variavel


    } catch (PDOException  $e){
        echo '{"error": {"text":' .$e->getMessage().'}';
    }

});

// ADD UM CLIENTE NA BASE (SHOW)

$app->post('/api/customers/add', function(Request $request, Response $response){
    
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    $sql = "INSERT INTO customers (first_name, last_name, phone, email, address, city, state) VALUES (:first_name, :last_name, :phone, :email, :address, :city, :state)";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':state',$state);

        $stmt->execute();

        echo '{"notice": {"text": "Customer added"}';
       
    } catch (PDOException  $e){
        echo '{"error": {"text":' .$e->getMessage().'}';
    }

});

//ATUALIZAR DADOS DE UM CLIENTE
$app->put('/api/customers/update/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');


    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    $sql = "UPDATE customers  SET
                first_name  = :first_name, 
                last_name   = :last_name,
                phone       = :phone,
                email       = :email,
                address     = :address,
                city        = :city,
                state       = :state
            WHERE id = $id";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':state',$state);

        $stmt->execute();

        echo '{"notice": {"text": "Customer Updated"}';
       
    } catch (PDOException  $e){
        echo '{"error": {"text":' .$e->getMessage().'}';
    }

});

// DELETE

$app->delete('/api/customers/delete/{id}', function(Request $request, Response $response){
        $id = $request->getAttribute('id');

    $sql = "DELETE from customers WHERE id = $id";

    try{
        // capturar os dados do banco montado no mysql
        $db = new db();
        // conectar
        $db = $db->connect();

        
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        
        echo '{"notice": {"text": "Customer deleted"}';

    } catch (PDOException  $e){
        echo '{"error": {"text":' .$e->getMessage().'}';
    }

});