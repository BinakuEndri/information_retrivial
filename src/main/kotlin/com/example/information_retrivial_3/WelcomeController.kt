package com.example.information_retrieval_3

import org.springframework.stereotype.Controller
import org.springframework.web.bind.annotation.GetMapping

@Controller
class WelcomeController {

    @GetMapping("/")
    fun welcome(): String {
        return "index" // Assuming your HTML file is named index.html
    }
}

