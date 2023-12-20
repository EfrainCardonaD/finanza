package com.example


/**
* Homeflow Technologies | Expense.
*
* @property id
* @property user_id
* @property category_id
* @property amount
*
* @constructor Create Expense model
*/
data class Expense( var user_id: Int? = null, var category_id: Int? = null, var amount: Double? = null,
)
