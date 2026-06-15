<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLanguage($lang)
    {
        // Check if the requested language is allowed
        if (in_array($lang, ['kh', 'en' ,'ch'])) {
            Session::put('locale', $lang); // Store language in session
        }

        return redirect()->back(); // Go back to previous page
    }
}