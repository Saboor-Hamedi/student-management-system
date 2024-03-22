<?php

namespace Thesis\controllers\profile;
use Exception;
use Thesis\config\Database;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;

/**
 * Summary of UserInformation
 */
class UserInformation
{
    private $database;
    private $errors = [];
    /**c
     * Summary of __construct
     */
    public function __construct()
    {
        $this->database = Database::GetInstance();
    }

    /**
     * Summary of validate_user_profile
     * @param mixed $user_main_id
     * @param mixed $user_country
     * @param mixed $user_address
     * @param mixed $user_post_code
     * @param mixed $phone_number
     * @return array
     */
    public function validate_user_profile($user_main_id, $user_country, $user_address, $user_post_code, $phone_number)
    {
        $validation = new Validation();
        $user_country_error = $validation->validate_names($user_country, [
            ['required', 'Country is required'],
            ['min_length', 'Country name must be at lest 2 character long', 2]
        ]);
        $user_address_error = $validation->validate_address($user_address, [
            ['required', 'Address is required'],
            ['min_length', 'Address must be at least 5 characters long', 5]
        ]);
        $user_post_code_error = $validation->validate_post_code($user_post_code, [
            ['required', 'Postal code is required'],
            ['pattern', 'Postal code must contain only numbers', '/^[0-9]+$/'],
            ['min_length', 'Postal code must be at least 5 characters long', 5]
        ]);
        $phone_number_error = $validation->validate_phone_number($phone_number, [
            ['required', 'Phone number is required'],
            ['pattern', 'Phone number must contain only numbers', '/^[0-9]+$/'],
            ['min_length', 'Phone number must be at least 10 characters long', 10]
        ]);
        if (!empty($user_country_error)) {
            $this->errors['user_country'] = $user_country_error;
        }
        if (!empty($user_address_error)) {
            $this->errors['user_address'] = $user_address_error;
        }
        if (!empty($user_post_code_error)) {
            $this->errors['user_post_code'] = $user_post_code_error;
        }
        if (!empty($phone_number_error)) {
            $this->errors['phone_number'] = $phone_number_error;
        }
        if (!empty($this->errors)) {
            return ['errors' => $this->errors];
        }
    }

    public function insertOrUpdateUserInformation($userId, $userCountry, $userAddress, $userPostCode, $phoneNumber)
    {
        try {
            $existingRow = $this->database->getUserId('school.userinformation', 'user_id', $userId);

            if (!$existingRow) {
                // Insert a new row
                $data = [
                    'user_id' => $userId,
                    'country' => $userCountry,
                    'address' => $userAddress,
                    'zip_code' => $userPostCode,
                    'phone_number' => $phoneNumber
                ];

                $this->database->insert('school.userinformation', $data);
                FlashMessage::setMessage('Profile inserted', 'primary');
            } else {
                // Update the existing row
                $where = 'user_id = :user_id';
                $data = [
                    'country' => $userCountry,
                    'address' => $userAddress,
                    'zip_code' => $userPostCode,
                    'phone_number' => $phoneNumber,
                    'user_id' => $userId
                ];

                $result = $this->database->update('school.userinformation', $data, $where);
                if (!$result) {
                    FlashMessage::setMessage('No changes made', 'info');
                } else {
                    FlashMessage::setMessage('Profile Updated', 'primary');
                }
            }
        } catch (Exception $e) {
            FlashMessage::addMessageWithException('Something went wrong', $e, 'danger');
        }
    }

    /**
     * Summary of perform_update
     * @param mixed $user_main_id
     * @param mixed $user_country
     * @param mixed $user_address
     * @param mixed $user_post_code
     * @param mixed $phone_number
     * @throws \Exception
     * @return array<string>
     */
    public function perform_update($user_main_id, $user_country, $user_address, $user_post_code, $phone_number)
    {
        // Perform the update in the database
        if (
            empty($user_country) ||
            empty($user_address) ||
            empty($user_post_code) ||
            empty($phone_number)
        ) {
            throw new Exception('All fields are required.');
        }
        $where = 'user_id = :user_id';
        $data = [
            'country' => $user_country,
            'address' => $user_address,
            'zip_code' => $user_post_code,
            'phone_number' => $phone_number,
            'user_id' => $user_main_id
        ];

        try {
            $this->database->update('school.userinformation', $data, $where);

            FlashMessage::setMessage('User Updated', 'primary');
        } catch (Exception $e) {
            FlashMessage::addMessageWithException('Something went wrong', $e, 'danger');
        }
    }
}
