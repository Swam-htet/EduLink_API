<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenantLandingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

     public function prepareForValidation(): void
    {
        $this->merge([
            'key' => $this->route('key')
        ]);
    }

    public function rules(): array
    {
        return [
            'key' => 'required|string|in:hero,features,statistics,testimonials,faqs,contact,programs,facilities',
            'value' => 'required|array',
            'value.title' => 'required_if:key,hero|string',
            'value.subtitle' => 'required_if:key,hero|string',
            'value.image' => 'required_if:key,hero|url',
            // 'value.cta' => 'required_if:key,hero|array',
            // 'value.cta.primary' => 'required_if:key,hero|string',
            // 'value.cta.secondary' => 'required_if:key,hero|string',

            'value.*.icon' => 'required_if:key,features,statistics|string',
            'value.*.title' => 'required_if:key,features|string',
            'value.*.description' => 'required_if:key,features|string',

            'value.*.value' => 'required_if:key,statistics|numeric',
            'value.*.label' => 'required_if:key,statistics|string',

            'value.*.name' => 'required_if:key,testimonials|string',
            'value.*.role' => 'required_if:key,testimonials|string',
            'value.*.organization' => 'required_if:key,testimonials|string',
            'value.*.content' => 'required_if:key,testimonials|string',
            'value.*.image' => 'required_if:key,testimonials|url',

            'value.*.question' => 'required_if:key,faqs|string',
            'value.*.answer' => 'required_if:key,faqs|string',

            'value.address' => 'required_if:key,contact|string',
            'value.email' => 'required_if:key,contact|email',
            'value.phone' => 'required_if:key,contact|string',
            'value.mapUrl' => 'required_if:key,contact|url',

            'value.primaryColor' => 'required_if:key,branding|string',
            'value.secondaryColor' => 'required_if:key,branding|string',
            'value.logo' => 'required_if:key,branding|url',

            'value.*.name' => 'required_if:key,programs,facilities|string',
            'value.*.grades' => 'required_if:key,programs|string',
            'value.*.description' => 'required_if:key,programs,facilities|string',
            'value.*.features' => 'required_if:key,programs|array',
            'value.*.image' => 'required_if:key,facilities|url',
        ];
    }
}