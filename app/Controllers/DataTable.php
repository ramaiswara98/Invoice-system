<?php

namespace App\Controllers;

class DataTable extends BaseController
{
    public function invoice()
{
    $db = db_connect();
    $searchValue = $this->request->getVar('search')['value'];
    $start = $this->request->getVar('start') ?? 0;  // Default to 0 if not set
    $length = $this->request->getVar('length') ?? 10;  // Default to 10 if not set

    // Initialize the WHERE clause
    $whereClause = "";
    if (!empty($searchValue)) {
        // Ensure proper escaping and add wildcards for the LIKE comparison
        $searchValue = $db->escapeLikeString($searchValue);
        $whereClause = " WHERE student.name LIKE '%" . $searchValue . "%'" .
                       " OR invoice.status LIKE '%" . $searchValue . "%'" .
                       " OR CAST(invoice.id AS CHAR) LIKE '%" . $searchValue . "%'";
    }

    // Full SQL query with placeholders for dynamic data
    $baseQuery = "SELECT 
        invoice.id AS invoice_id,
        student.name AS student_name,
        invoice.status AS status,
        currency.code AS code,
        SUM((items.qty * class.price) - items.discount) AS amount
    FROM 
        invoice
    INNER JOIN 
        student ON invoice.student_id = student.id
    INNER JOIN 
        items ON invoice.id = items.invoice_id
    INNER JOIN 
        class ON items.class_id = class.id
    INNER JOIN 
        currency ON class.currency_id = currency.id"
    . $whereClause . 
    " GROUP BY 
        invoice.id, student.name, currency.code
    ORDER BY invoice.id ASC
    LIMIT $start, $length";

    // Execute query and fetch results
    $invoice_query = $db->query($baseQuery);
    $invoice = $invoice_query->getResult();

    // Debug: Check the final SQL query
    // echo "SQL Query: " . $baseQuery;

    // Process and format the result set
    $fInvoice = array();
    foreach ($invoice as $inv) {
        $formattedAmount = $inv->code . " " . number_format($inv->amount, 2);
        $fInvoice[] = array(
            $inv->invoice_id,
            $inv->student_name,
            $inv->status,
            $formattedAmount,
            "<td><a href='" . base_url() . "admin/invoice/" . $inv->invoice_id . "' type='button' class='btn btn-secondary'><i class='fa-solid fa-eye'></i></a><a href='" . base_url() . "admin/edit-payment/" . $inv->invoice_id . "' type='button' class='btn btn-warning' style='margin-right:10px;margin-left:10px'><i class='fa-solid fa-pen-to-square'></i></a><a href='" . base_url() . "admin/delete-invoice/" . $inv->invoice_id . "' type='button' class='btn btn-danger'><i class='fa-solid fa-trash'></i></a></td>"
        );
    }

    $record['data'] = $fInvoice;
    $record['recordsTotal'] = count($fInvoice);// Assuming a method that counts all records without filter
    $record['recordsFiltered'] =  $this->countAllRecords();; // Using filtered count

    return json_encode($record);
}

public function countAllRecords() {
    $db = db_connect();
    $query = $db->query("SELECT COUNT(*) AS total FROM invoice");
    $result = $query->getRow();
    return $result->total;
}

}
