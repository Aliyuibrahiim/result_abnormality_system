<?php

namespace App\Livewire\Admin\ValidationRules;

use Livewire\Component;
use App\Models\ValidationRule;

class Index extends Component
{
    public $stdDevOutlier = 2.0;
    public $highSeverityStdDev = 3.0;
    public $suspiciousCaPercent = 80.0;
    public $suspiciousExamPercent = 30.0;

    public function mount()
    {
        $this->stdDevOutlier = $this->getRuleCondition('std_dev_outlier', 2.0);
        $this->highSeverityStdDev = $this->getRuleCondition('high_severity_std_dev', 3.0);
        $this->suspiciousCaPercent = $this->getRuleCondition('suspicious_ca_percentage', 80.0);
        $this->suspiciousExamPercent = $this->getRuleCondition('suspicious_exam_percentage', 30.0);
    }

    private function getRuleCondition($name, $default)
    {
        $rule = ValidationRule::where('name', $name)->first();
        return $rule ? (float)$rule->condition : $default;
    }

    private function setRuleCondition($name, $value)
    {
        ValidationRule::updateOrCreate(
            ['name' => $name],
            [
                'rule_type' => 'statistical',
                'condition' => (string)$value,
            ]
        );
    }

    public function saveSettings()
    {
        $this->validate([
            'stdDevOutlier' => 'required|numeric|min:0.1',
            'highSeverityStdDev' => 'required|numeric|min:0.1',
            'suspiciousCaPercent' => 'required|numeric|min:1|max:100',
            'suspiciousExamPercent' => 'required|numeric|min:1|max:100',
        ]);

        $this->setRuleCondition('std_dev_outlier', $this->stdDevOutlier);
        $this->setRuleCondition('high_severity_std_dev', $this->highSeverityStdDev);
        $this->setRuleCondition('suspicious_ca_percentage', $this->suspiciousCaPercent);
        $this->setRuleCondition('suspicious_exam_percentage', $this->suspiciousExamPercent);

        session()->flash('message', 'Statistical Validation Rules updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.validation-rules.index')->layout('layouts.app');
    }
}
