<?php

namespace App\Controllers;

use CodeIgniter\Validation\ValidationInterface;

class Tools extends BaseController
{
    public function honmei(): string
    {
        $rules = [
            'birth_year' => 'required|is_natural_no_zero|greater_than_equal_to[1900]|less_than_equal_to[2100]',
        ];
        $messages = [
            'birth_year' => [
                'required'               => '生まれ年（西暦）を入力してください。',
                'is_natural_no_zero'     => '生まれ年は西暦の数字で入力してください。',
                'greater_than_equal_to'  => '生まれ年は1900年から2100年の間で入力してください。',
                'less_than_equal_to'     => '生まれ年は1900年から2100年の間で入力してください。',
            ],
        ];

        return $this->render('tools/honmei_kichihoi', '本命星／今年吉方位', $rules, $messages);
    }

    public function kichijitsu(): string
    {
        $rules = [
            'event' => 'required|in_list[hikkoshi,nyukyo,keiyaku]',
            'year'  => 'required|is_natural_no_zero|greater_than_equal_to[2000]|less_than_equal_to[2100]',
            'month' => 'required|is_natural_no_zero|greater_than_equal_to[1]|less_than_equal_to[12]',
        ];
        $messages = [
            'event' => [
                'required' => '用途を選んでください。',
                'in_list'  => '用途の選択が正しくありません。',
            ],
            'year' => [
                'required'              => '年を入力してください。',
                'is_natural_no_zero'    => '年は数字で入力してください。',
                'greater_than_equal_to' => '年は2000年から2100年の間で入力してください。',
                'less_than_equal_to'    => '年は2000年から2100年の間で入力してください。',
            ],
            'month' => [
                'required'              => '月を選んでください。',
                'is_natural_no_zero'    => '月は1から12で選んでください。',
                'greater_than_equal_to' => '月は1から12で選んでください。',
                'less_than_equal_to'    => '月は1から12で選んでください。',
            ],
        ];

        return $this->render('tools/kichijitsu', '吉日日暦', $rules, $messages);
    }

    public function kimon(): string
    {
        $choice = 'required|in_list[yes,no,unknown]';
        $rules  = [
            'entrance'  => $choice,
            'water'     => $choice,
            'furniture' => $choice,
        ];
        $choiceMessages = [
            'required' => '選択してください。',
            'in_list'  => '選択が正しくありません。',
        ];
        $messages = [
            'entrance'  => $choiceMessages,
            'water'     => $choiceMessages,
            'furniture' => $choiceMessages,
        ];

        return $this->render('tools/kimon_qa', '鬼門問答', $rules, $messages);
    }

    /**
     * @param array<string, string>              $rules
     * @param array<string, array<string, string>> $messages
     */
    private function render(string $view, string $title, array $rules, array $messages): string
    {
        $submitted = $this->request->getGet('submit') !== null;
        $errors    = [];
        $accepted  = false;

        if ($submitted) {
            /** @var ValidationInterface $validation */
            $validation = service('validation');
            $validation->setRules($rules, $messages);

            if ($validation->withRequest($this->request)->run()) {
                $accepted = true;
            } else {
                $errors = $validation->getErrors();
            }
        }

        $values = [];

        foreach (array_keys($rules) as $field) {
            $values[$field] = (string) $this->request->getGet($field);
        }

        return view($view, [
            'title'     => $title,
            'values'    => $values,
            'errors'    => $errors,
            'accepted'  => $accepted,
            'submitted' => $submitted,
        ]);
    }
}
