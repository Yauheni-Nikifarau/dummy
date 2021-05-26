<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpWord\TemplateProcessor;

class Order extends Model
{
    use HasFactory;

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createReport ()
    {
        $user = auth()->user();

        $paid = $this->paid ? 'Yes' : 'No';

        $imageFileName = str_replace('storage//', '', $this->trip->image);
        $imagePath = storage_path('app/public') . '/' . $imageFileName;

        $template = new TemplateProcessor('template.docx');

        $template->setValue('name', $user->name);
        $template->setValue('surname', $user->surname);
        $template->setValue('orderId', $this->id);
        $template->setValue('hotelName', $this->trip->hotel->name);
        $template->setValue('hotelCountry', $this->trip->hotel->country);
        $template->setValue('dateIn', $this->trip->date_in);
        $template->setValue('dateOut', $this->trip->date_out);
        $template->setValue('orderCreatedAt', $this->created_at);
        $template->setValue('price', $this->price);
        $template->setValue('paid', $paid);
        $template->setImageValue('image', $imagePath);

        $filename = "dummy_order_{$user->name}_{$user->surname}_{$this->id}_" . Carbon::now()->format('Y-m-d_H:i:s');
        $fileFullPath = storage_path('app/public/ordersReports' . '/' . $filename . '.docx') ;

        $template->saveAs($fileFullPath);

        return $fileFullPath;
    }
}
