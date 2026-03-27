import js from '@eslint/js';
import pluginVue from 'eslint-plugin-vue';
import vueTsConfig from '@vue/eslint-config-typescript';

export default [
    js.configs.recommended,
    ...pluginVue.configs['flat/recommended'],
    ...vueTsConfig(),
    {
        files: ['resources/js/**/*.{js,ts,vue}'],
        rules: {
            'vue/multi-word-component-names': 'off',
            'vue/require-default-prop': 'off',
            '@typescript-eslint/no-unused-vars': ['error', { argsIgnorePattern: '^_' }],
        },
    },
    {
        ignores: ['vendor/**', 'node_modules/**', 'public/**', 'bootstrap/ssr/**', '**/*.d.ts'],
    },
];
