<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Api\V1\Lookups\MedicalHistoryOption;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_history_options', function (Blueprint $table) {
            $table->bigIncrements('medical_history_option_id');
            $table->text('description');
            $table->timestamps();
        });

        MedicalHistoryOption::insert([
            ['description' => 'Heart or cardiovascular disorders: e.g. coronary artery disease, chest pains, circulation problems, varicose veins, high blood pressure, venous, ulcers,, cholesteral, deep vein thrombosis'],
            ['description' => 'Granular disorders: eg diabetes, thyroid, hormonal problems'],
            ['description' => 'Breathing or respiratory disorders: e.g. asthma, bronchitis, shortness or breath, chest infections, TB, emphysema, pulmonary embolism.'],
            ['description' => 'Ear, nose, throat or eye problems e.g. hayfever, tonsilitis, sinusitis, cataracts, eye infections, deafness, ear infections.'],
            ['description' => 'Stomach, intestines, liver or gallblader problems: e.g. ulcers, colitis, repeated indigestion, irritable bowel, change in bowl habits, hepatitis, piles rectal bleeding.'],
            ['description' => 'Cancer, tumours, growths, cysts or moles that itch or bleed.'],
            ['description' => 'Skin problems: e.g. eczema, rashes, psoriasis, acne.'],
            ['description' => 'Brain or nervous system disorders: e.g. stroke, migraines, repeated headaches, ms, epilepsy, nerve pains, fits, chronic fatigue syndrome.'],
            ['description' => 'Muscle or skeletal problems: e.g. arthritis, cartilage and ligament problems, back and neck problems, sprains, joint replacements, gout, sciatica.'],
            ['description' => 'Urinary problems e.g. bladder, kidney or prostate problems, urinary infections, incontinence.'],
            ['description' => 'Blood disorders e.g. anaemia, hepatitis, HIV, abnormal blood tests.'],
            ['description' => 'Reproductive system disorders: e.g. pregnancy and/or childbirth problems, heavy or irregular periods, fibroids, endometriosis, infertility, abnormal smears, menopause.'],
            ['description' => 'Allergies'],
            ['description' => 'Psychological disorders: e.g. depression, schizophrenia, anorexia, bulimia, compulsive disorders, stress, anxiety, addiction.'],
            ['description' => 'Auto-immune disorders: e.g sjogren\'s syndrome, lupus, multiple sclerosis, rheumatoid arthritis.'],
            ['description' => 'Taking any chronic medication?'],
            ['description' => 'Receiving treatment of any kind?'],
            ['description' => 'Pregnant or expecting a pregnancy soon?'],
            ['description' => 'Current smoker or ex-smoker']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_history_options');
    }
};
