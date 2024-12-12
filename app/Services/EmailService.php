<?php

namespace App\Services;

use App\Models\User;


class EmailService
{
    protected $email;
    protected $users;
    public function __construct()
    {
        $this->email = \Config\Services::email();
        $this->users = model(User::class);
    }
    public function sendEmail($toEmail, $subject, $message, $userName, $redirectName, $redirectPage)
    {
        // $this->email = \Config\Services::email();

        $this->email->setFrom('mauenice188@gmail.com', 'Ball For Life');
        $this->email->setTo($toEmail);
        $this->email->setSubject($subject);
        $this->email->setMessage('
                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;background-color:#f6f6f6;width:100%" width="100%" bgcolor="#f6f6f6">
                                        <tbody><tr>
                                            <td style="font-family:sans-serif;font-size:14px;vertical-align:top" valign="top">&nbsp;</td>
                                            <td style="display:block;margin:0 auto;max-width:580px;padding:10px;width:580px" width="580">
                                                <div style="box-sizing:border-box;display:block;margin:0 auto;max-width:580px;padding:20px;background:#ffffff;border-radius:3px">
                                                    <table role="presentation" style="border-collapse:separate;width:100%;background:#ffffff;border-radius:3px" width="100%">
                                                        <tbody><tr>
                                                            <td style="font-family:sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:20px" valign="top">
                                                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%" width="100%">
                                                                    <tbody><tr>
                                                                        <td style="font-family:sans-serif;font-size:14px;vertical-align:top" valign="top">
                                                                            <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;margin-bottom:15px">Hi ' . $userName . ',</p>
                                                                            <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;margin-bottom:15px"> </p><p> ' . $message . ' </p>
                                                                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%" width="100%">
                                                                                <tbody><tr>
                                                                                    <td align="center" style="font-family:sans-serif;font-size:14px;vertical-align:top;padding-bottom:15px" valign="top">
                                                                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:auto">

                                                                                            <tbody><tr>
                                                                                                <td style="font-family:sans-serif;vertical-align:top;padding-bottom:10px;padding-top:10px;color:#999999;font-size:12px;text-align:center" valign="top" align="center"><a href=" ' . base_url($redirectPage) . ' " style="border:solid 1px #3498db;border-radius:5px;box-sizing:border-box;display:inline-block;font-size:14px;font-weight:bold;margin:0;padding:12px 25px;text-decoration:none;text-transform:capitalize;background-color:#3498db;border-color:#3498db;color:#ffffff" target="_blank">Go to ' . $redirectName . '</a>
                                                                                                </td>
                                                                                                <td style="font-family:sans-serif;font-size:14px;vertical-align:top;border-radius:5px;text-align:center;background-color:#3498db" valign="top" align="center" bgcolor="#3498db"> 
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody></table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody></table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody></table>
                                                            </td>
                                                        </tr>
                                                    </tbody></table>
                                                </div><span class="im">
                                                <div style="clear:both;margin-top:10px;text-align:center;width:100%">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%" width="100%">
                                                        <tbody><tr>
                                                            <td style="font-family:sans-serif;vertical-align:top;padding-bottom:10px;padding-top:10px;color:#999999;font-size:12px;text-align:center" valign="top" align="center">
                                                                    <a href="' . base_url($redirectPage) . '" style="color:#999999;font-size:12px;text-align:center;text-decoration:none" target="_blank">Ball For Life</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-family:sans-serif;vertical-align:top;padding-bottom:10px;color:#999999;font-size:12px;text-align:center;margin-top:5px;" valign="top" align="center">
                                                                A life in Ball-ance
                                                            </td>
                                                        </tr>
                                                        
                                                    </tbody></table>
                                                </div>
                                            </span></td>
                                            <td style="font-family:sans-serif;font-size:14px;vertical-align:top" valign="top">&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table> 
                                ');

        if ($this->email->send()) {
            return 'Email successfully sent!';
        } else {
            // Debugging errors
            return $this->email->printDebugger(['headers', 'subject', 'body']);
        }
    }

    public function notifyAdmin($subject, $message, $redirectName, $redirectPage)
    {

        $admins = $this->users->where('is_deleted', false)
            ->where('role', 'Admin')
            ->findAll();

        // error_log('ADMINS: ' . print_r($admins, true));
        foreach ($admins as $admin) {

            error_log('Admin Email: ' . $admin['email']);
            $this->email->setFrom('mauenice188@gmail.com', 'Ball For Life');
            $this->email->setTo($admin['email']);
            $this->email->setSubject($subject);
            $this->email->setMessage('
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;background-color:#f6f6f6;width:100%" width="100%" bgcolor="#f6f6f6">
                                            <tbody><tr>
                                                <td style="font-family:sans-serif;font-size:14px;vertical-align:top" valign="top">&nbsp;</td>
                                                <td style="display:block;margin:0 auto;max-width:580px;padding:10px;width:580px" width="580">
                                                    <div style="box-sizing:border-box;display:block;margin:0 auto;max-width:580px;padding:20px;background:#ffffff;border-radius:3px">
                                                        <table role="presentation" style="border-collapse:separate;width:100%;background:#ffffff;border-radius:3px" width="100%">
                                                            <tbody><tr>
                                                                <td style="font-family:sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:20px" valign="top">
                                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%" width="100%">
                                                                        <tbody><tr>
                                                                            <td style="font-family:sans-serif;font-size:14px;vertical-align:top" valign="top">
                                                                                <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;margin-bottom:15px">Hi ' . $admin['firstname'] . ' ' . $admin['lastname'] . ',</p>
                                                                                <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;margin-bottom:15px"> </p><p> ' . $message . ' </p>
                                                                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%" width="100%">
                                                                                    <tbody><tr>
                                                                                        <td align="center" style="font-family:sans-serif;font-size:14px;vertical-align:top;padding-bottom:15px" valign="top">
                                                                                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:auto">
    
                                                                                                <tbody><tr>
                                                                                                    <td style="font-family:sans-serif;vertical-align:top;padding-bottom:10px;padding-top:10px;color:#999999;font-size:12px;text-align:center" valign="top" align="center"><a href=" ' . base_url($redirectPage) . ' " style="border:solid 1px #3498db;border-radius:5px;box-sizing:border-box;display:inline-block;font-size:14px;font-weight:bold;margin:0;padding:12px 25px;text-decoration:none;text-transform:capitalize;background-color:#3498db;border-color:#3498db;color:#ffffff" target="_blank">Go to ' . $redirectName . '</a>
                                                                                                    </td>
                                                                                                    <td style="font-family:sans-serif;font-size:14px;vertical-align:top;border-radius:5px;text-align:center;background-color:#3498db" valign="top" align="center" bgcolor="#3498db"> 
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody></table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody></table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </div><span class="im">
                                                    <div style="clear:both;margin-top:10px;text-align:center;width:100%">
                                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%" width="100%">
                                                            <tbody><tr>
                                                                <td style="font-family:sans-serif;vertical-align:top;padding-bottom:10px;padding-top:10px;color:#999999;font-size:12px;text-align:center" valign="top" align="center">
                                                                        <a href="' . base_url($redirectPage) . '" style="color:#999999;font-size:12px;text-align:center;text-decoration:none" target="_blank">Ball For Life</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-family:sans-serif;vertical-align:top;padding-bottom:10px;color:#999999;font-size:12px;text-align:center;margin-top:5px;" valign="top" align="center">
                                                                    A life in Ball-ance
                                                                </td>
                                                            </tr>
                                                            
                                                        </tbody></table>
                                                    </div>
                                                </span></td>
                                                <td style="font-family:sans-serif;font-size:14px;vertical-align:top" valign="top">&nbsp;</td>
                                            </tr>
                                            </tbody>
                                        </table> 
                                    ');
                                    
            if ($this->email->send()) {
                $results[] = [
                    'email' => $admin['email'],
                    'status' => 'success',
                    'message' => 'Email successfully sent!'
                ];
                error_log('Email successfully sent to: ' . $admin['email']);
            } else {
                $results[] = [
                    'email' => $admin['email'],
                    'status' => 'failure',
                    'error' => $this->email->printDebugger(['headers', 'subject', 'body'])
                ];
                error_log('Failed to send email to: ' . $admin['email']);
                error_log($this->email->printDebugger(['headers', 'subject', 'body']));
            }
        }
    }
}
