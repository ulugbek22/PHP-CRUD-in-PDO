<?php

require_once 'User.class.php';

$user = new User();

// CREATE =========================================================================

// $id = $user->add(['username' => 'Nozima', 'password' => '101', 'role' => 'user']);
// if ( $id ) echo "User #$id created.";
// else echo 'User hasnt been created.';

// READ ===========================================================================

//print_r( $user->get(['id' => 1]) );

// Get all the users

//foreach ( $user->get() as $user ) print_r($user);

// Get all the users whose roles are user

//foreach ( $user->get(['role' => 'user']) as $user ) print_r($user);

// UPDATE =========================================================================

// $update = $user->update(56, ['username' => 'Updated', 'role' => 'admin']);
// if ( $update ) echo 'Updated.';
// else echo 'Not updated.';

// DELETE ==========================================================================

// if ( $user->delete(['username' => 'anora']) ) echo "deleted";
// else echo "Not deleted";