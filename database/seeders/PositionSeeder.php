<?php

namespace Database\Seeders;

use App\Models\Master\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Deputy Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Deputy Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Deputy Regional Airport Facility,Equipment,& Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Deputy Regional Finance,Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Deputy Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Deputy General Manager Airport Operation & Security Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Airside Operation Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T1 & Cargo Airside Operation Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T1 Apron Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Cargo Apron Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T2 & T3 Airside Operation Service Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T2 Apron Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 Apron Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Airport Rescue & Fire Fighting",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Rescue & Fire Fighting Operations Performance Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Aircraft Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Building Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Rescue & Fire Fighting Maintenance & Prevention Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Rescue & Fire Fighting Maintenance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Rescue & Fire Fighting Exercise & Prevention Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Airport Security Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Screening & Surveillances Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T1 Screening Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T2 Screening Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 Domestic Screening Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 International Screening Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "CCTV Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Protection Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Perimeter & Vital Object Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Non-Terminal & Traffic Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Cargo Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T1 Protection Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T2 Protection Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 Protection Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Landside Operation Services & Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Landside & Cargo Operation Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Landside Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Cargo Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "TOD Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Public Transportation Division Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "APMS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Mass Public Transport Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Personal Public Transport Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T1 & T2 Services Support Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T1 Services Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T2 Services Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 Services Support Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 Domestic Services Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 International Services Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Deputy General Manager Airport Commercial Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Aero Business",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "International Aero Commercial Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "International PJP4U,PJKP2U & Aviobridge Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "International Airlines Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "International PJP2U & Counter Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Domestic Aero Commercial Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Domestic PJP4U,PJKP2U & Aviobridge Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Domestic Airlines Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Domestic PJP2U & Counter Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Non-Aero Business",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Retail & Concession Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Retail Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Concession Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Food & Beverage,Lounge,& Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Food & Beverage Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Lounge,Hotel & Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Advertising & Landside Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Advertising Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Landside Service Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Parking Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Fitting Out & Visual Merchandising Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Fitting Out Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Visual Merchandising Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Cargo & Property Management Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Cargo Related Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Property Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Deputy General Manager Airport Facility,Equipment & Technology Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Airport Electrical Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Energy & Power Supply Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "High & Medium Voltage Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Main Power Station 1 Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Main Power Station 2 Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Main Power Station 3 Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Electrical Protection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Electrical Network Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Electrical Utility & Visual Aid Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "UPS & Converter Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "North Visual Aid Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "South Visual Aid Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Electrical Utility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Terminal & Non-Terminal Electrical Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T1 Electrical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T2 Electrical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 Electrical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Non-Terminal Electrical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Airport Mechanical Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Mechanical Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Sanitation Facility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Water Treatment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Ground Support System Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Equipment Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Equipment & Workshop Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "APMS Facility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Baggage Handling System Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Terminal & Non-Terminal Mechanical Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T1 Mechanical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T2 Mechanical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 Mechanical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 Ventilation & Air Conditioning Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Non-Terminal Mechanical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Airport Electronics Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Safety & Security Electronic Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T1 Safety & Security Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T2 Safety & Security Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 Safety & Security Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Non-Terminal Safety & Security Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "General Electronic Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T1 General Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T2 General Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 General Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Non-Terminal General Electronic Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Airport Technology Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "IT Public Service & Security System Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Public Service & IT System Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Safety & Security IT Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Data Network & IT Non-Public Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Communication & Data Network Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "IT Non-Public Service Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Control Center IT Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Airside Facility & Support Services",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airside Infrastructure Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "North Runway Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "South Runway Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airfield Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Accessibility & Environment Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Accessibility & Road Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Landscape Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Airport Building Facility Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Terminal 1,2 & Non-Terminal Building Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Terminal 1 Building Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Terminal 2 Building Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Non-Terminal Building Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Terminal 3 Building Division Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Terminal 3 Building Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Terminal 3 Infrastructure Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Deputy General Manager Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Human Capital Solution & Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Human Capital Solution Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Talent Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Human Capital Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Human Capital Development Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "People Development Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Learning Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy General Services & CSR",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "General Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Office Administration Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Office Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Corporate Social Responsibility Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Community Engagement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Sustainability Initiative Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Procurement",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Operation & Services Procurement Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Operation Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Facility & Equipment Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Business & Supporting Procurement Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Business Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Supporting Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Deputy General Manager Finance & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Finance & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Finance Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Cash Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Account Receivable Collection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Receivable Administration Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Risk Management & Governance Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Risk Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Governance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Accounting & Tax",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Account & Budgeting Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Budgeting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "General Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Management Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Tax Management Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Tax Compliance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Tax Reporting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Asset Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Asset Information Control Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Fixed Asset & Inventory Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Asset Write Off Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Asset Evaluation & Readiness Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Land Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Asset Utilization & Dispute Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Airport Operation Control Center",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Operation Control Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Operation Maintenance Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Communication & Legal",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Branch Communication Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Communication Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Secretariat & Internal Relations Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Legal Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Legal Aid & Institutional Relations Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Airport Customer Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Customer Handling Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T1 Customer Handling Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T2 Customer Handling Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 Customer Handling Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Non-Terminal Customer Handling Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Cleanliness & Customer Improvement Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Cleanliness Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Customer Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Deputy Quality & Safety Management System",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Operation Quality Control Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Service Quality Control Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Maintenance Quality Control Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Safety Management Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "General Manager Terminal 1",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T1 Operation & Services Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T1 Terminal Operation Control Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "General Manager Terminal 2",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T2 Operation & Services Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T2 Terminal Operation Control Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "General Manager Terminal 3",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 International Departure Operation & Services Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 Domestic Departure Operation & Services Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 International & Domestic Arrival Operation & Services Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "T3 Terminal Operation Control Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Operation Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Customer Experience Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Facility Team Leader",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Executive General Manager Operasional",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of Safety,Risk & Quality Control",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of Airside Operation & Landside Service",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of Airport Security",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of Airport Rescue & Fire Fighting",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of Facility Maintenance",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of Infrastructure & Maintenance",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Officer in Charge",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Safety & Risk Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Quality & Performance Management Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Operation Landside,Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Executive General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Manager of Operation & Service",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of Airport Operation & Service",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager Of Airport Rescue & Fire Fighting",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of Airport Security",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Manager of Airport Maintenance",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of Electronic Facility & IT",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of Electrical & Mechanical Facility",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of Infrastructure",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Manager of Finance & General Affairs",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of Finance",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of General Affairs",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of Safety & Risk Management",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of Airport Quality & Data Management",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "CGK",
                "position_name" => "Assistant Manager of Procurement & Legal",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Regional Airport Facility,Equipment,& Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Regional Finance,Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Deputy General Manager Airport Operation & Security Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Airside & ARFF Operation Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airside Operation Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Security Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Protection Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Screening & Surveillance Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Landside Services Support Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Terminal Service Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Non Terminal Service Support Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Deputy General Manager Airport Commercial Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Aero Business Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Domestic Aero Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "International Aero Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Non-Aero Business Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Retail And Concession Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "F&B,Lounge,And Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Advertising And Landside Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Fitting Out & Visual Merchandise Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Cargo & Property Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Deputy General Manager Airport Facility & Equipment Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Equipment Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Mechanical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Electrical Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Electronics & Technology Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Facility Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airside Facility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Landside Facility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Terminal Facility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Deputy General Manager Finance,Hc & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Human Capital,GS,& CSR Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Human Capital Development Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Human Capital Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Procurement Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Operation & Services Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Business & Supporting Procurement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Finance,Risk,Accounting,Tax & Asset Management Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Asset Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Finance & Risk Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Accounting & Tax Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Operation Control Centre Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Operation Control Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Operation Maintenance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Branch Communication & Legal Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Branch Communication Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Legal Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Customer Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Customer Handling & Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Cleanliness & Customer Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Quality & Safety Management System Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Operation Quality Control Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Service Quality Control Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Maintenance Quality Control Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Safety Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "General Manager Terminal",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Terminal International Departure Operation & Services Excellence Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Terminal International Arrival Operation & Services Excellence Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Terminal Domestic Departure Operation & Services Excellence Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Terminal Domestic Arrival Operation & Services Excellence Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Safety,Risk & Performance Management Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Safety Management System & Ohs Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Quality,Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Operation Land Side,Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Non-Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Human Capital Business Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Legal,Compliance & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Safety,Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Operation,Services,Security & Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Rescue & Fire Fighting & Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Facilities,Equipment & Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Operation And Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Security & Service Improvement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Facilities,Equipment,& Technology Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "DPS",
                "position_name" => "Airport Administration Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Deputy Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation & Service Quality Assurance",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation & Service Improvement",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Deputy Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Connectivity",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Commercial Assurance",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Deputy Regional Airport Facility,Equipment,& Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Deputy Regional Finance,Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Deputy Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Safety,Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Landside,Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Safety & Risk Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Quality & Performance Management Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Landside,Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Safety,Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation,Services,Security & Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Equipment & Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Safety,Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Landside,Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Safety & Risk Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Quality & Performance Management Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Landside,Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Safety & Risk Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Quality & Performance Management Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Landside,Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Safety,Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation Landside,Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Security & Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Facilities,Equipment,& Technology Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Administration Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation And Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Security & Service Improvement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Facilities,Equipment,& Technology Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Administration Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Security & Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Facilities,Equipment,& Technology Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Administration Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Security & Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Facilities,Equipment,& Technology Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BTJ",
                "position_name" => "Airport Administration Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Deputy Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Deputy Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Deputy Regional Airport Facility,Equipment,& Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Deputy Regional Finance,Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Deputy Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Safety,Risk & Performance Management Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Quality,Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation Land Side & Terminal Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Security Protection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Security Screening Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Non-Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Human Capital Business Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Safety,Risk,& Performance Management Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Quality,Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation & Services Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation Landside & Terminal Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Security Protection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Security Screening Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Non Aeronautical Terminal 1 Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Non Aeronautical Terminal 2 Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Human Capital Business Partner Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Safety,Risk,& Performance Management Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Quality,Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation Landside,Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Non Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Human Capital Business Partner Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation,Service,Security & Arff Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Facilities,Equipment,& Technology Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Commercial & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Administration & Procurement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Legal,Compliance,& Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Safety,Risk,& Performance Management Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation,Services,Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation Landside & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation,Services & Security Coordinator",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Technical  Coordinator",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Administration Coordinator",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Legal,Compliance,and Stakeholder Relation Manager",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Safety,Risk,and Performance Management Manager",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Procurement Manager",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation,Services,Security,and Technical Senior Manager",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Operation and Service Improvement Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Rescue,Fire Fighting,and Security Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Facilities Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Equipment Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Technology Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Commercial and Administration Senior Manager",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Airport Commercial Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Finance Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "YIA",
                "position_name" => "Human Capital Business Partner and General Services Manager",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Deputy Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Deputy Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Deputy Regional Airport Facility,Equipment,& Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Deputy Regional Finance,Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Deputy Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Safety,Risk,& Performance Management Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Quality,Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation Landside & Terminal Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Security Protection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Security Screening Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Non Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Human Capital Business Partner Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Legal,Compliance & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Safety,Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation,Services,Security & Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Rescue & Fire Fighting & Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Facilities,Equipment & Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Safety,Risk & Performance Management Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Quality,Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation Landside,Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Non Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Human Capital Business Partner Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation,Service,Security & Safety Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Facilities,Equipment,& Technology Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Commercial & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Administration & Procurement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Legal,Compliance & Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Safety,Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Operation Landside,Terminal,& Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Non Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Cargo & Business Development Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "UPG",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Regional CEO",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Deputy Regional Airport Operation & Services",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation & Services Quality Assurance & Improvement",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Deputy Regional Airport Commercial Development",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Deputy Regional Airport Facility,Equipment,& Technology Readiness",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Deputy Regional Finance,Asset & Risk Management",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Deputy Regional Human Capital Solution & Business Support",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Safety,Risk & Performance Management Division Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Quality,Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation Land Side & Terminal Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Security Protection Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Security Screening Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Non-Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Human Capital Business Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Safety & Risk Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Quality & Performance Management Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation Landside,Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Airside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Landside Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Legal & Compliance Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Stakeholder Relation Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Procurement Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Safety,Risk & Performance Management Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Safety Management System & OHS Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Quality,Risk & Performance Management Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Environment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation Landside,Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Rescue & Fire Fighting Operation Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Commercial Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Non Aeronautical Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Human Capital Business Partner Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "General Manager",
                "assigned_roles" => "risk otorisator"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Procurement & Legal Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Safety,Risk & Performance Management Department Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation Center Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation,Services & Security Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation Airside Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Operation Landside,Terminal & Service Improvement Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Rescue & Fire Fighting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Security Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Technical Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Facilities Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Equipment Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Technology Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Commercial & Administration Division Head",
                "assigned_roles" => "risk owner,risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Airport Commercial Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Finance Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Accounting Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Human Capital Business Partner & General Services Department Head",
                "assigned_roles" => "risk admin"
            ],
            [
                "personnel_area_code" => "BPN",
                "position_name" => "Corporate Social Responsibility Department Head",
                "assigned_roles" => "risk admin"
            ]
        ];

        foreach ($positions as $position) {
            Position::where('personnel_area_code', $position['personnel_area_code'])
                ->where('position_name', $position['position_name'])
                ->update([
                    'assigned_roles' => $position['assigned_roles']
                ]);
        }
    }
}
