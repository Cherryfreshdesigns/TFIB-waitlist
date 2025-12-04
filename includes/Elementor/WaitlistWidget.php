<?php
/**
 * Elementor widget: TFIB Waitlist
 */

namespace TFIB\Waitlist\Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WaitlistWidget extends Widget_Base {

	public function get_name() {
		return 'tfib_waitlist';
	}

	public function get_title() {
		return __( 'TFIB Waitlist', 'tfib-waitlist' );
	}

	public function get_icon() {
		return 'eicon-notification';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'tfib-waitlist' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => __( 'Button label', 'tfib-waitlist' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Join Waitlist', 'tfib-waitlist' ),
			]
		);

		$this->add_control(
			'email_label',
			[
				'label'       => __( 'Email label', 'tfib-waitlist' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Email address *', 'tfib-waitlist' ),
			]
		);

		$this->add_control(
			'first_name_label',
			[
				'label'       => __( 'First name label', 'tfib-waitlist' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'First name (optional)', 'tfib-waitlist' ),
			]
		);

		$this->add_control(
			'success_message',
			[
				'label'       => __( 'Success message', 'tfib-waitlist' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'You have been added to the waitlist.', 'tfib-waitlist' ),
			]
		);

		$this->add_control(
			'error_message',
			[
				'label'       => __( 'Error message', 'tfib-waitlist' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Something went wrong. Please try again.', 'tfib-waitlist' ),
			]
		);

		$this->add_control(
			'extra_class',
			[
				'label'       => __( 'Extra CSS class', 'tfib-waitlist' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'my-custom-class',
			]
		);

		$this->add_control(
			'notice_heading',
			[
				'label'       => __( 'Notice', 'tfib-waitlist' ),
				'type'        => Controls_Manager::HEADING,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'show_notice',
			[
				'label'        => __( 'Show out-of-stock notice', 'tfib-waitlist' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'tfib-waitlist' ),
				'label_off'    => __( 'No', 'tfib-waitlist' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'notice_title',
			[
				'label'       => __( 'Notice heading', 'tfib-waitlist' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'This product is coming soon.', 'tfib-waitlist' ),
				'condition'   => [
					'show_notice' => 'yes',
				],
			]
		);

		$this->add_control(
			'notice_description',
			[
				'label'       => __( 'Notice description', 'tfib-waitlist' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => __( "Don't worry! Enter your email, and we'll notify you when it's available again.", 'tfib-waitlist' ),
				'condition'   => [
					'show_notice' => 'yes',
				],
			]
		);

		$this->add_control(
			'notice_position',
			[
				'label'       => __( 'Notice position', 'tfib-waitlist' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'before' => __( 'Before button', 'tfib-waitlist' ),
					'after'  => __( 'After button', 'tfib-waitlist' ),
				],
				'default'     => 'before',
				'condition'   => [
					'show_notice' => 'yes',
				],
			]
		);

		$this->add_control(
			'notice_icon',
			[
				'label'       => __( 'Notice Icon', 'tfib-waitlist' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-envelope',
					'library' => 'fa-solid',
				],
				'condition'   => [
					'show_notice' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Styles', 'tfib-waitlist' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => __( 'Button Color', 'tfib-waitlist' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2d7d2d',
				'selectors' => [
					'{{WRAPPER}} .tfib-waitlist__trigger' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .tfib-waitlist__submit'  => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => __( 'Button Text Color', 'tfib-waitlist' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tfib-waitlist__trigger' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tfib-waitlist__submit'  => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dialog_background',
			[
				'label'     => __( 'Modal Background Color', 'tfib-waitlist' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tfib-waitlist__dialog' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dialog_text_color',
			[
				'label'     => __( 'Modal Text Color', 'tfib-waitlist' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .tfib-waitlist__dialog' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'success_background',
			[
				'label'     => __( 'Success Message Background', 'tfib-waitlist' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d4edda',
				'selectors' => [
					'{{WRAPPER}} .tfib-waitlist__message--success'    => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .tfib-waitlist__success-message'     => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'success_text_color',
			[
				'label'     => __( 'Success Message Text Color', 'tfib-waitlist' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#155724',
				'selectors' => [
					'{{WRAPPER}} .tfib-waitlist__message--success'    => 'color: {{VALUE}};',
					'{{WRAPPER}} .tfib-waitlist__success-message p'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_color_heading',
			[
				'label'     => __( 'Overlay Settings', 'tfib-waitlist' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'     => __( 'Overlay Color', 'tfib-waitlist' ),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => true,
				'default'   => 'rgba(0, 0, 0, 0.5)',
				'selectors' => [
					'{{WRAPPER}} .tfib-waitlist__overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_styling_heading',
			[
				'label'     => __( 'Button Styling', 'tfib-waitlist' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => __( 'Button Padding', 'tfib-waitlist' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => 12,
					'right'    => 24,
					'bottom'   => 12,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tfib-waitlist__submit'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_border_width',
			[
				'label'      => __( 'Border Width', 'tfib-waitlist' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__trigger' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tfib-waitlist__submit'  => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'tfib-waitlist' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 6,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__trigger' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tfib-waitlist__submit'  => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_hover_heading',
			[
				'label'     => __( 'Button Hover', 'tfib-waitlist' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'     => __( 'Hover Background Color', 'tfib-waitlist' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1f5621',
				'selectors' => [
					'{{WRAPPER}} .tfib-waitlist__trigger:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .tfib-waitlist__submit:hover'  => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => __( 'Hover Text Color', 'tfib-waitlist' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tfib-waitlist__trigger:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tfib-waitlist__submit:hover'  => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_transition',
			[
				'label'      => __( 'Transition Duration (ms)', 'tfib-waitlist' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'ms' ],
				'range'      => [
					'ms' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 50,
					],
				],
				'default'    => [
					'unit' => 'ms',
					'size' => 300,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__trigger' => 'transition: all {{SIZE}}ms ease;',
					'{{WRAPPER}} .tfib-waitlist__submit'  => 'transition: all {{SIZE}}ms ease;',
				],
			]
		);

		$this->add_control(
			'button_hover_shadow',
			[
				'label'       => __( 'Add Shadow on Hover', 'tfib-waitlist' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => __( 'Yes', 'tfib-waitlist' ),
				'label_off'   => __( 'No', 'tfib-waitlist' ),
				'return_value' => 'yes',
				'default'     => 'yes',
				'selectors'   => [
					'{{WRAPPER}} .tfib-waitlist__trigger:hover' => 'box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);',
					'{{WRAPPER}} .tfib-waitlist__submit:hover'  => 'box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);',
				],
			]
		);

		$this->add_control(
			'notice_styling_heading',
			[
				'label'     => __( 'Notice Styling', 'tfib-waitlist' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'notice_background',
			[
				'label'     => __( 'Notice Background Color', 'tfib-waitlist' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f0f4f8',
				'selectors' => [
					'{{WRAPPER}} .tfib-waitlist__notice' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'notice_border_color',
			[
				'label'     => __( 'Notice Border Color', 'tfib-waitlist' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e0e8f0',
				'selectors' => [
					'{{WRAPPER}} .tfib-waitlist__notice' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'notice_border_width',
			[
				'label'      => __( 'Notice Border Width', 'tfib-waitlist' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 1,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__notice' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'notice_border_style',
			[
				'label'   => __( 'Notice Border Style', 'tfib-waitlist' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'solid'  => __( 'Solid', 'tfib-waitlist' ),
					'dashed' => __( 'Dashed', 'tfib-waitlist' ),
					'dotted' => __( 'Dotted', 'tfib-waitlist' ),
					'double' => __( 'Double', 'tfib-waitlist' ),
					'groove' => __( 'Groove', 'tfib-waitlist' ),
					'ridge'  => __( 'Ridge', 'tfib-waitlist' ),
					'inset'  => __( 'Inset', 'tfib-waitlist' ),
					'outset' => __( 'Outset', 'tfib-waitlist' ),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .tfib-waitlist__notice' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'notice_border_radius',
			[
				'label'      => __( 'Notice Border Radius', 'tfib-waitlist' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 6,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__notice' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'notice_title_color',
			[
				'label'     => __( 'Notice Title Color', 'tfib-waitlist' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1a3a52',
				'selectors' => [
					'{{WRAPPER}} .tfib-waitlist__notice-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'notice_text_color',
			[
				'label'     => __( 'Notice Text Color', 'tfib-waitlist' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .tfib-waitlist__notice-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'typography_heading',
			[
				'label'     => __( 'Typography', 'tfib-waitlist' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_font_size',
			[
				'label'      => __( 'Button Font Size', 'tfib-waitlist' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 30,
					],
					'em' => [
						'min' => 0.5,
						'max' => 2,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__trigger' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tfib-waitlist__submit'  => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'notice_title_font_size',
			[
				'label'      => __( 'Notice Title Font Size', 'tfib-waitlist' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 28,
					],
					'em' => [
						'min' => 0.5,
						'max' => 1.8,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__notice-title' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'notice_text_font_size',
			[
				'label'      => __( 'Notice Text Font Size', 'tfib-waitlist' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 24,
					],
					'em' => [
						'min' => 0.5,
						'max' => 1.6,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__notice-description' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'label_font_size',
			[
				'label'      => __( 'Form Label Font Size', 'tfib-waitlist' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 20,
					],
					'em' => [
						'min' => 0.5,
						'max' => 1.4,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__field label' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'spacing_heading',
			[
				'label'     => __( 'Spacing', 'tfib-waitlist' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'notice_margin_bottom',
			[
				'label'      => __( 'Notice Margin Bottom', 'tfib-waitlist' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 40,
					],
					'em' => [
						'min' => 0,
						'max' => 2.5,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 24,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__notice' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'notice_padding',
			[
				'label'      => __( 'Notice Padding', 'tfib-waitlist' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => 16,
					'right'    => 20,
					'bottom'   => 16,
					'left'     => 20,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__notice' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'notice_gap',
			[
				'label'      => __( 'Notice Icon-Content Gap', 'tfib-waitlist' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
					'em' => [
						'min' => 0,
						'max' => 2,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__notice' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => __( 'Button Padding', 'tfib-waitlist' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => 12,
					'right'    => 24,
					'bottom'   => 12,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tfib-waitlist__submit'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_field_margin',
			[
				'label'      => __( 'Form Field Margin Bottom', 'tfib-waitlist' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 40,
					],
					'em' => [
						'min' => 0,
						'max' => 2.5,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 24,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__field' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_field_padding',
			[
				'label'      => __( 'Form Input Padding', 'tfib-waitlist' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => 12,
					'right'    => 12,
					'bottom'   => 12,
					'left'     => 12,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .tfib-waitlist__field input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tfib-waitlist__field select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! is_product() ) {
			return;
		}

		global $product;
		if ( ! $product instanceof \WC_Product ) {
			return;
		}

		if ( ! $product->is_type( 'variable' ) ) {
			return;
		}

		$settings = $this->get_settings_for_display();
		$classes  = [ 'tfib-waitlist-container' ];
		if ( ! empty( $settings['extra_class'] ) ) {
			$classes[] = $settings['extra_class'];
		}

		$wrapper_class = implode( ' ', array_map( 'sanitize_html_class', $classes ) );
		$product_id    = $product->get_id();

		$data = [
			'button_text'           => isset( $settings['button_text'] ) ? $settings['button_text'] : '',
			'email_label'           => isset( $settings['email_label'] ) ? $settings['email_label'] : '',
			'first_name_label'      => isset( $settings['first_name_label'] ) ? $settings['first_name_label'] : '',
			'success_message'       => isset( $settings['success_message'] ) ? $settings['success_message'] : '',
			'error_message'         => isset( $settings['error_message'] ) ? $settings['error_message'] : '',
			'show_notice'           => isset( $settings['show_notice'] ) ? $settings['show_notice'] : 'yes',
			'notice_title'          => isset( $settings['notice_title'] ) ? $settings['notice_title'] : '',
			'notice_description'    => isset( $settings['notice_description'] ) ? $settings['notice_description'] : '',
			'notice_position'       => isset( $settings['notice_position'] ) ? $settings['notice_position'] : 'before',
		];

		echo '<div class="' . esc_attr( $wrapper_class ) . '" data-product-id="' . esc_attr( $product_id ) . '" data-tfib-settings="' . esc_attr( wp_json_encode( $data ) ) . '"></div>';
	}
}
