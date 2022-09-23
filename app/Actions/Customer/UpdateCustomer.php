<?php

declare(strict_types=1);

namespace App\Actions\Customer;

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateCustomer
{
    private static function contactsCreateUpdateDelete(array $receivedContacts, Customer $customer): void
    {
        $customerContactsId = $customer->contacts()->get('id')->pluck('id')->toArray();
        $receivedContactsId = Arr::pluck($receivedContacts, 'id');
        
        foreach ($receivedContacts as $contact) {
            if (isset($contact['id'])) {
                Contact::where('id', $contact['id'])->update($contact);
            } else {
                $customer->contacts()->create($contact);
            }
        }

        foreach (array_diff($customerContactsId, $receivedContactsId) as $contactId) {
            Contact::where('id', $contactId)->delete();
        }
    }

    public static function run(array $data, Customer $customer): void
    {
        $customerData = Arr::except($data, 'contacts');
        $contacts = Arr::only($data, 'contacts')['contacts'];
        DB::transaction(function() use($customerData, $contacts, $customer) {
            $customer->update($customerData);
            self::contactsCreateUpdateDelete($contacts, $customer);
        });
    }
}