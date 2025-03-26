<?php
/**
 * Create config file for error message
 *
 * PHP version 8.1
 *
 * @category GeneralManagement
 * @package  Lang\en
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
/*
|--------------------------------------------------------------------------
| Flash messages: For error
|--------------------------------------------------------------------------
 */
return [
    'ERROR'                         => 'Something went wrong.',
    'RECORD_NOT_FOUND'              => 'Record not found',
    'MOBILE_EXIST'                  => 'The mobile number has already been taken.',
    'INVALID_REQUEST'               => 'Invalid Request.',

    //User and Admin Authentication
    'LOGIN_ERROR'                   => 'Invalid credentials',
    'EMAIL_REQUIRED'                => 'Email ID can’t be empty.',
    'EMAIL_INVALID'                 => 'Enter your registered Email ID',
    'PASSWORD_RESET_ERROR'          => 'Password reset email not send.',
    'PASSWORD_REQUIRED'             => 'Password field can\'t be empty.',
    'PASSWORD_MIN'                  => 'Password must contain 8 characters.',
    'PASSWORD_MAX'                  => 'Password cannot contain more than 16 characters.',
    'PASSWORD_REGEX'                => 'Password should be alphanumeric and required at least one uppercase and special character.',
    'ACCOUNT_INACTIVE'              => 'Your account is inactive. Please contact v.me support team',
    'REQUIRED_MOBILE_NUMBER'        => 'Mobile Number can’t be empty.',
    'MOBILE_NUMBER_INVALID'         => 'Enter your registered mobile number',
    'ACCOUNT_VERIFIED'              => 'Please verify your account',
    'ACCOUNT_UNVERIFIED'            => 'Your account is not verified. Please verify your account using your mobile number.',

    //Forgot password
    'REQUIRED_EMAIL'                => 'Please enter Email ID',
    'INVALID_EMAIL'                 => 'Please enter a valid Email ID',
    'REQUIRED_PASSWORD'             => 'Please Enter Password',
    'MIN_PASSWORD'                  => 'Password should be minimum of 8 characters',
    'MAX_PASSWORD'                  => 'Password should be maximum 20 characters',
    'INVALID_MOBILE_NUMBER'         => 'Please enter a valid Mobile Number',
    'PASSPORT_TOKEN_ERROR'          => "Invalid Email Or Password",
    'PASSWORD_THROTTLED'            => "To many attempts, Please wait before retrying",
    'INACTIVATE_ACCOUNT'            => "Your account is inactive. Please contact to the admin.",
    'CPASSWORD_REQUIRED'            => 'Confirm password can\'t be empty',
    'PASSWORD_RESET_TOKEN'          => 'Password reset token is invalid',
    'EMAIL_ALREADY_VERIFIED'        => 'Email already verified',
    'USER_DOESNT_EXIST'             => 'User does not exist',
    'TOKEN_EXPIRED'                 => 'Your email varification link is expired.',
    'OTP_SEND_LIMIT'                => "You have exceeded the maximum number of attempts to resend OTP. Please contact to admin.",
    'OTP_EXPIRED'                   => 'Otp is expired',
    'OTP_NOT_MATCHED'               => 'Please enter valid OTP.',
    'ENTER_MOBILE_EXIST'            => 'This mobile number is already registered with us, Please use another number.',
    'ENTER_EMAIL_EXIST'             => 'This email address is already registered with us, Please use another email.',
    'MOBILE_VERIFIED'               => 'Please verify your mobile number.',
    'EMAIL_VERIFIED'                => 'Please verify email address.',
    'MOBILE_EMAIL_VERIFIED'         => 'Please verify your mobile and email address.',
    'ACCOUNT_DELETED'               => 'Your account has been removed. Please contact support team.',
    'REQUIRED_UUID'                 => 'User uuid required',
    'VALIDATION_ERROR'              => 'Validation failed.',
    'CURRENT_PASSWORD_ERROR'        => 'You have entered incorrect old password',
    'SAME_PASSWORD_ERROR'           => 'New password can not be same as the old password!',
    'ACCOUNT_UNVERIFIED'            => 'Your account is not verified.',
    'ACCOUNT_ALREADY_VERIFIED'      => 'Your account is already verified.',
    'PASSWORD_RESET_TOKE_INVALID'   => 'Invalid password reset token.',
    'NO_RECORD_FOUND'               => 'No records found',
    'USER_NOT_FOUND'                => 'User not available',
    'USER_UNAUTHORIZED'             => 'Unauthenticated',
    'INVALID_TOKEN'                 => 'Invalid token or Token is expired',
    'UNAUTHORIZED_ACCESS'           => 'Unauthorized Access!',
    'CATEGORY_DELETE_ERROR_PRODUCT' => 'You can not delete this category, it\'s associated with Product',
    'SUB_CATEGORY_DELETE_ERROR_PRODUCT' => 'You can not delete this sub category, it\'s associated with Product',
    'CATEGORY_DELETE_ERROR_SUB_CAT' => 'You can not delete this category, it\'s associated with Sub Category',
];
