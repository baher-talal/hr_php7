<?php

namespace App\Http\Controllers;

require_once 'htmltodocx_converter/h2d_htmlconverter.php';

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator,
    Input,
    Redirect,
    Lang;
use DB;
use Response;
use Sunra\PhpSimple\HtmlDomParser;
use PDF;

class TemplateController extends Controller {

    protected $layout = "layouts.main";
    protected $data = array();
    public $module = 'template';
    static $per_page = '10';

    public function __construct() {

        // $this->beforeFilter('csrf', array('on' => 'post'));
        $this->model = new Template();

        $this->info = $this->model->makeInfo($this->module);
        $this->middleware(function ($request, $next) {
            $this->access = $this->model->validAccess($this->info['id']);
            return $next($request);
        });

        $this->data = array(
            'pageTitle' => $this->info['title'],
            'pageNote' => $this->info['note'],
            'pageModule' => 'template',
            'return' => self::returnUrl()
        );
    }

    public function getIndex(Request $request) {

        if ($this->access['is_view'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id');
        $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
        // End Filter sort and order for query 
        // Filter Search for query		
        $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');


        $page = $request->input('page', 1);
        $params = array(
            'page' => $page,
            'limit' => (!is_null($request->input('rows')) ? filter_var($request->input('rows'), FILTER_VALIDATE_INT) : static::$per_page ),
            'sort' => $sort,
            'order' => $order,
            'params' => $filter,
            'global' => (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
        );
        // Get Query 
        $results = $this->model->getRows($params);

        // Build pagination setting
        $page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;
        $pagination = new Paginator($results['rows'], $results['total'], $params['limit']);
        $pagination->setPath('template');

        $this->data['rowData'] = $results['rows'];
        // Build Pagination 
        $this->data['pagination'] = $pagination;
        // Build pager number and append current param GET
        $this->data['pager'] = $this->injectPaginate();
        // Row grid Number 
        $this->data['i'] = ($page * $params['limit']) - $params['limit'];
        // Grid Configuration 
        $this->data['tableGrid'] = $this->info['config']['grid'];
        $this->data['tableForm'] = $this->info['config']['forms'];
        $this->data['colspan'] = \SiteHelpers::viewColSpan($this->info['config']['grid']);
        // Group users permission
        $this->data['access'] = $this->access;
        // Detail from master if any
        // Master detail link if any 
        $this->data['subgrid'] = (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array());
        // Render into template
        return view('template.index', $this->data);
    }

    function getUpdate(Request $request, $id = null) {

        if ($id == '') {
            if ($this->access['is_add'] == 0)
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        if ($id != '') {
            if ($this->access['is_edit'] == 0)
                return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        }

        $row = $this->model->find($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('templates');
        }


        $this->data['id'] = $id;
        return view('template.form', $this->data);
    }

    public function getShow($id = null) {

        if ($this->access['is_detail'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus', 'error');

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data['row'] = $row;
        } else {
            $this->data['row'] = $this->model->getColumnTable('templates');
        }
        $this->data['items'] = DB::table('template_items')->where('template_id', $id)->get();
        $this->data['id'] = $id;
        $this->data['access'] = $this->access;
        return view('template.view', $this->data);
    }

    function postSave(Request $request) {

        $rules = $this->validateForm();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = $this->validatePost('tb_template');

            $id = $this->model->insertRow3($data, $request->input('id'));

            if (!is_null($request->input('apply'))) {
                $return = 'template/update/' . $id . '?return=' . self::returnUrl();
            } else {
                $return = 'template?return=' . self::returnUrl();
            }

            // Insert logs into database
            if ($request->input('id') == '') {
                \SiteHelpers::auditTrail($request, 'New Data with ID ' . $id . ' Has been Inserted !');
            } else {
                \SiteHelpers::auditTrail($request, 'Data with ID ' . $id . ' Has been Updated !');
            }

            return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus', 'success');
        } else {

            return Redirect::to('template/update/' . $id)->with('messagetext', \Lang::get('core.note_error'))->with('msgstatus', 'error')
                            ->withErrors($validator)->withInput();
        }
    }

    public function postDelete(Request $request) {

        if ($this->access['is_remove'] == 0)
            return Redirect::to('dashboard')
                            ->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus', 'error');
        // delete multipe rows 
        if (count($request->input('id')) >= 1) {
            $this->model->destroy($request->input('id'));

            \SiteHelpers::auditTrail($request, "ID : " . implode(",", $request->input('id')) . "  , Has Been Removed Successfull");
            // redirect
            return Redirect::to('template')
                            ->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus', 'success');
        } else {
            return Redirect::to('template')
                            ->with('messagetext', 'No Item Deleted')->with('msgstatus', 'error');
        }
    }

    public function download_word($id) {

        $row = Template::FindOrFail($id);
        $items = DB::table('template_items')->where('template_id', $id)->get();
        $content = view('template.preview', compact('items', 'row'))->render();

//       // Creating the new document...

        $phpword_object = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpword_object->createSection();

// HTML Dom object:
        $html_dom = HtmlDomParser::str_get_html($content);

// Note, we needed to nest the html in a couple of dummy elements.
// Create the dom array of elements which we are going to work on:
        $html_dom_array = $html_dom->find('html', 0)->children();
//


        $initial_state = array(
            // Required parameters:
            'phpword_object' => &$phpword_object, // Must be passed by reference.
            // Optional parameters - showing the defaults if you don't set anything:
            'current_style' => array('size' => '11'), // The PHPWord style on the top element - may be inherited by descendent elements.
            'parents' => array(0 => 'body'), // Our parent is body.
            'list_depth' => 0, // This is the current depth of any current list.
            'context' => 'section', // Possible values - section, footer or header.
            'pseudo_list' => TRUE, // NOTE: Word lists not yet supported (TRUE is the only option at present).
            'pseudo_list_indicator_font_name' => 'Wingdings', // Bullet indicator font.
            'pseudo_list_indicator_font_size' => '7', // Bullet indicator size.
            'pseudo_list_indicator_character' => 'l ', // Gives a circle bullet point with wingdings.
            'table_allowed' => TRUE, // Note, if you are adding this html into a PHPWord table you should set this to FALSE: tables cannot be nested in PHPWord.
            'treat_div_as_paragraph' => TRUE, // If set to TRUE, each new div will trigger a new line in the Word document.
            // Optional - no default:    
            'style_sheet' => $this->htmltodocx_styles_example(), // This is an array (the "style sheet") - returned by htmltodocx_styles_example() here (in styles.inc) - see this function for an example of how to construct this array.
        );

// Convert the HTML and put it into the PHPWord object
        htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $initial_state);

// Clear the HTML dom object:
        $html_dom->clear();
        unset($html_dom);

// Save File
        $h2d_file_uri = tempnam('', 'htd');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpword_object, 'Word2007');
        $objWriter->save($h2d_file_uri);

// Download the file:
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=example.docx');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($h2d_file_uri));
        ob_clean();
        flush();
        $status = readfile($h2d_file_uri);
        unlink($h2d_file_uri);
        exit;
// Saving the document as HTML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('helloWorld.docx'));
        return response()->download(storage_path('helloWorld.docx'));
    }

    public function download_pdf($id) {

        $row = Template::FindOrFail($id);
        $items = DB::table('template_items')->where('template_id', $id)->get();
        $content = view('template.preview', compact('items', 'row'))->render();

        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf::SetTitle($row->title);

        // set some language dependent data:
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'ar';
        $lg['w_page'] = 'page';
        // set some language-dependent strings (optional)
        $pdf::setLanguageArray($lg);
        $pdf::setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf::setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf::SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf::SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf::setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf::setFontSubsetting(true);
        $pdf::SetFont('freeserif', '', 12);
        $pdf::AddPage();
        $pdf::writeHTML($content, true, false, true, false, '');
        $filename = 'template ' . $row->id . '-' . date("d/m/Y") . '.pdf';
        $pdf::Output($filename);
    }

    public function htmltodocx_styles_example() {

        // Set of default styles - 
        // to set initially whatever the element is:
        // NB - any defaults not set here will be provided by PHPWord.
        $styles['default'] = array(
            'size' => 11,
            'rtl' => true,
        );

        // Element styles:
        // The keys of the elements array are valid HTML tags;
        // The arrays associated with each of these tags is a set
        // of PHPWord style definitions.
        $styles['elements'] = array(
            'body' => array(
                'rtl' => true,
                'border' => 'dashed',
            ),
            'div' => array(
                'rtl' => true,
                'border' => 'dashed',
            ),
            'p' => array(
                'rtl' => true,
            ),
            'h1' => array(
                'bold' => TRUE,
                'size' => 20,
                'rtl' => true,
            ),
            'h2' => array(
                'bold' => TRUE,
                'size' => 15,
                'spaceAfter' => 150,
                'rtl' => true,
            ),
            'h3' => array(
                'size' => 12,
                'bold' => TRUE,
                'spaceAfter' => 100,
                'rtl' => true,
            ),
            'li' => array(
            ),
            'ol' => array(
                'spaceBefore' => 200,
            ),
            'ul' => array(
                'spaceAfter' => 150,
            ),
            'b' => array(
                'bold' => TRUE,
                'rtl' => true,
            ),
            'em' => array(
                'italic' => TRUE,
            ),
            'i' => array(
                'italic' => TRUE,
            ),
            'strong' => array(
                'bold' => TRUE,
            ),
            'b' => array(
                'bold' => TRUE,
            ),
            'sup' => array(
                'superScript' => TRUE,
                'size' => 6,
            ), // Superscript not working in PHPWord 
            'u' => array(
                'underline' => \PhpOffice\PhpWord\Style\Font::UNDERLINE_SINGLE,
            ),
            'a' => array(
                'color' => '0000FF',
                'underline' => \PhpOffice\PhpWord\Style\Font::UNDERLINE_SINGLE,
            ),
            'table' => array(
                // Note that applying a table style in PHPWord applies the relevant style to
                // ALL the cells in the table. So, for example, the borderSize applied here
                // applies to all the cells, and not just to the outer edges of the table:
                'borderColor' => '000000',
                'borderSize' => 10,
            ),
            'th' => array(
                'borderColor' => '000000',
                'borderSize' => 10,
            ),
            'td' => array(
                'borderColor' => '000000',
                'borderSize' => 10,
            ),
        );

        // Classes:
        // The keys of the classes array are valid CSS classes;
        // The array associated with each of these classes is a set
        // of PHPWord style definitions.
        // Classes will be applied in the order that they appear here if
        // more than one class appears on an element.
        $styles['classes'] = array(
            'underline' => array(
                'underline' => \PhpOffice\PhpWord\Style\Font::UNDERLINE_SINGLE,
            ),
            'purple' => array(
                'color' => '901391',
            ),
            'green' => array(
                'color' => '00A500',
            ),
            'text-center' => array(
                'align' => 'center',
                'rtl' => true,
            ),
            'bordered' => array(
                'rtl' => true,
            ),
        );

        // Inline style definitions, of the form:
        // array(css attribute-value - separated by a colon and a single space => array of
        // PHPWord attribute value pairs.    
        $styles['inline'] = array(
            'text-decoration: underline' => array(
                'underline' => \PhpOffice\PhpWord\Style\Font::UNDERLINE_SINGLE,
            ),
            'vertical-align: left' => array(
                'align' => 'left',
            ),
            'vertical-align: middle' => array(
                'align' => 'center',
            ),
            'vertical-align: right' => array(
                'align' => 'right',
            ),
        );

        return $styles;
    }

}
