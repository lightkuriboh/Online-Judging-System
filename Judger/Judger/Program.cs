using System;
using System.IO;
using System.Threading;
using System.Diagnostics;

namespace Judger
{	
	public class MainClass
	{		
		public static void Main (string[] args) {
			while (true) {
				string[] list_pas = Directory.GetFiles (GlobalConstant.source, "*.pas");
				if (!(list_pas == null || list_pas.Length == 0)) 
					foreach (string s in list_pas) {																									
						Judger New = new Judger ();
						Classifier myClassifier = new Classifier ();
						New.Test_address = GlobalConstant.Test_address_origin + myClassifier.Reconize_name_of_Problem(s);
						New.submissionID = myClassifier.Reconize_ID_of_Problem (s);
						//Define compiler
						string Compiler = "g++";
						if (myClassifier.Reconize_Language (s) == ".pas")
							Compiler = "fpc";
						//----------------------------------------
						New.Process (s, myClassifier.Reconize_Language(s), Compiler);	
					}
				//------------------------------------------------------------------
				string[] list_cpp = Directory.GetFiles (GlobalConstant.source, "*.cpp");
				if (!(list_cpp == null || list_cpp.Length == 0)) 
					foreach (string s in list_cpp) {																									
						Judger New = new Judger ();
						Classifier myClassifier = new Classifier ();
						New.Test_address = GlobalConstant.Test_address_origin + myClassifier.Reconize_name_of_Problem(s);
						New.submissionID = myClassifier.Reconize_ID_of_Problem (s);
						//Define compiler
						string Compiler = "g++";
						if (myClassifier.Reconize_Language (s) == ".pas")
							Compiler = "fpc";
						//-----------------------------------------
						New.Process (s, myClassifier.Reconize_Language(s), Compiler);	
					}
				Thread.Sleep (1000);
			}
		}
	}
}
